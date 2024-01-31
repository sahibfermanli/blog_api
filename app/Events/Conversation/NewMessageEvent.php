<?php

namespace App\Events\Conversation;

use App\Http\Resources\App\Conversation\ConversationMessageResource;
use App\Models\ConversationMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ConversationMessage $conversationMessage;
    private Collection $receiverIds;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ConversationMessage $conversationMessage)
    {
        $this->conversationMessage = $conversationMessage;
        $this->receiverIds = $conversationMessage->participants()->where('user_id', '<>', $this->conversationMessage->user_id)->pluck('user_id');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel[]
     */
    public function broadcastOn(): array
    {
        $data = [
            new PrivateChannel('chat.' . 2),
        ];


        foreach ($this->receiverIds as $receiverId) {
            $data[] = new PrivateChannel('user.' . $receiverId);
        }

        return $data;
    }

    // The event's broadcast name.
    public function broadcastAs(): string
    {
        return 'new-message';
    }

    // Get the data to broadcast.
    public function broadcastWith(): array
    {
        return ['message' => new ConversationMessageResource($this->conversationMessage->load('user'))];
    }
}
