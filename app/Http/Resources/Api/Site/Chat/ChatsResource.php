<?php

namespace App\Http\Resources\Api\Site\Chat;

use App\Http\Resources\Api\Site\Comments\CommentsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_user
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $uuid
 * @property mixed $users
 * @property mixed $messages_count
 * @property mixed $un_read_messages_count
 */
class ChatsResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => implode(', ', data_get($this->users, '*.name')),
            'all_messages_count' => $this->messages_count,
            'un_read_messages_count' => $this->un_read_messages_count,
            'created_date' => $this->created_at?->toDateTimeString(),
        ];
    }
}
