<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $is_active
 * @property mixed $comments_count
 * @property mixed $blogs_count
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $email
 */
class UsersResource extends JsonResource
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
            'full_name' => $this->name . ' ' . $this->surname,
            'email' => $this->email,
            'blogs_count' => $this->blogs_count,
            'comments_count' => $this->comments_count,
            'is_active' => (bool) $this->is_active,
            'created_date' => $this->created_at?->toDateTimeString(),
        ];
    }
}
