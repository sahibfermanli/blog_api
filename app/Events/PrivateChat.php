<?php

namespace App\Events;

use App\Http\Resources\Api\Site\Chat\ChatMessagesResource;
use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public ChatMessage $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */

    public function broadcastWith(): array
    {
        return ['message' => ChatMessagesResource::make($this->message)];
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat-channel.' . $this->message->receiver_id);
    }
}
