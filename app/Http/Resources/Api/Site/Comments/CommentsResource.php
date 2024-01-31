<?php

namespace App\Http\Resources\Api\Site\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_user
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $body
 */
class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray(Request $request): array
    {
        $created_user = $this->created_user;
        $created_by = $created_user?->name . ' ' . $created_user?->surname;

        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_by' => blank($created_by) ? '---' : $created_by,
            'created_date' => $this->created_at?->longRelativeDiffForHumans(),
        ];
    }
}
