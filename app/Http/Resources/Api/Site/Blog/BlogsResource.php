<?php

namespace App\Http\Resources\Api\Site\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title_az
 * @property mixed $created_user
 * @property mixed $created_at
 * @property mixed $id
 * @property mixed $is_active
 * @property mixed $image
 * @property mixed $title
 * @property mixed $description
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
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_by' => blank($created_by) ? '---' : $created_by,
            'created_date' => $this->created_at?->toDateTimeString(),
        ];
    }
}
