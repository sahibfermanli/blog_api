<?php

namespace App\Http\Resources\Api\Site\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 * @property mixed $is_active
 * @property mixed $id
 * @property mixed $description
 * @property mixed $body
 * @property mixed $images
 */
class MyBlogResource extends JsonResource
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
            'images' => $this->images,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'is_active' => $this->is_active,
        ];
    }
}
