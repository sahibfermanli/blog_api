<?php

namespace App\Http\Controllers\Api\Site;

use App\Events\PrivateChat;
use App\Events\PrivateTest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Requests\Api\Site\Chat\MessageSendRequest;
use App\Http\Requests\Api\Site\Chat\StartNewChatRequest;
use App\Http\Resources\Api\GeneralResource;
use App\Http\Resources\Api\Site\Chat\ChatMessagesResource;
use App\Http\Resources\Api\Site\Chat\ChatsResource;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function getChats(GeneralListRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();

        $chats = Chat::query()
            ->with([
                'users' => fn($q) => $q->where('chat_users.user_id', '!=', auth()->user()->id),
            ])
            ->withCount('messages')
            ->withCount('unReadMessages')
            ->orderByDesc('id')
            ->paginate($data['limit'] ?? 10);

        return ChatsResource::collection($chats);
    }

    public function getChatMessages(Request $request, int $chat_id): AnonymousResourceCollection
    {
        ChatMessage::query()
            ->where('chat_id', $chat_id)
            ->where('receiver_id', auth()->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = ChatMessage::query()
            ->with(['sender', 'receiver'])
            ->where('chat_id', $chat_id)
            ->orderByDesc('id')
            ->paginate(10);

        return ChatMessagesResource::collection($messages);
    }

    public function sendMessage(MessageSendRequest $request, Chat $chat): AnonymousResourceCollection
    {
        $validated = $request->validated();

        $chat->load([
            'users' => fn($q) => $q->where('chat_users.user_id', '!=', auth()->user()->id)
        ]);

        foreach ($chat->users as $receiver) {
            $chat->messages()->create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiver->id,
                'message' => $validated['message'],
            ]);
        }

        return $this->getChatMessages($request, $chat->id);
    }

    public function startNewChat(StartNewChatRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $chat = Chat::query()->create(['uuid' => Str::uuid()]);

        $chat->messages()->create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $validated['user_id'],
            'message' => $validated['message'],
        ]);

        $users = [];
        $users[] = [
            'chat_id' => $chat->id,
            'user_id' => auth()->user()->id,
            'created_by' => auth()->user()->id,
            'created_at' => now(),
        ];

        $users[] = [
            'chat_id' => $chat->id,
            'user_id' => $validated['user_id'],
            'created_by' => auth()->user()->id,
            'created_at' => now(),
        ];

        ChatUser::query()->insert($users);

        return response()->json(
            GeneralResource::make([
                'message' => 'Paid successfully!',
                'id' => $chat->id,
            ])
        );
    }
}
