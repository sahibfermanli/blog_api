<?php

namespace App\Http\Resources\Api\Site\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $sender
 * @property mixed $receiver
 * @property mixed $sender_id
 * @property mixed $receiver_id
 * @property mixed $message
 * @property mixed $read_at
 */
class ChatMessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'sender' => $this->sender?->name ?? '',
            'receiver' => $this->receiver?->name ?? '',
            'message' => $this->message,
            'read_at' => $this->read_at,
            'created_date' => $this->created_at?->toDateTimeString(),
        ];
    }
}
