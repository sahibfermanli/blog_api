<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Site\User\UsersListResource;
use App\Models\ChatUser;
use App\Models\User;

class UserController extends Controller
{
    public function show_all()
    {
        $chats = ChatUser::query()
            ->where('user_id', auth()->user()->id)
            ->select('chat_id')
            ->get()
            ->pluck('chat_id')
            ->toArray();

        $users = ChatUser::query()
            ->whereIn('chat_id', $chats)
            ->where('user_id', '!=', auth()->user()->id)
            ->get()
            ->pluck('user_id')
            ->toArray();

        $items = User::query()
            ->active()
            ->where('id', '!=', auth()->user()->id)
            ->whereNotIn('id', $users)
            ->orderBy('name')
            ->select('id', 'name', 'surname')
            ->get();

        return UsersListResource::collection($items);
    }
}
