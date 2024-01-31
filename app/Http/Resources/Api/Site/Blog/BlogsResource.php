<?php

namespace App\Http\Resources\Api\Site\Blog;

use App\Http\Resources\Api\Site\Comments\CommentsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_user
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $is_active
 * @property mixed $images
 * @property mixed $title
 * @property mixed $description
 * @property mixed $comments_count
 * @property mixed $comments
 */
class BlogsResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->images[0]['url'] ?? null,
            'description' => $this->description,
            'comments_count' => $this->comments_count,
            'is_active' => (bool) $this->is_active,
            'created_by' => blank($created_by) ? '---' : $created_by,
            'created_date' => $this->created_at?->toDateTimeString(),
            'comments' => CommentsResource::collection($this->comments),
        ];
    }
}
