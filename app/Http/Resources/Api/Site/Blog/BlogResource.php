<?php

namespace App\Http\Resources\Api\Site\Blog;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 * @property mixed $is_active
 * @property mixed $id
 * @property mixed $description
 * @property mixed $body
 * @property mixed $images
 * @property mixed $created_user
 * @property mixed $created_at
 */
class BlogResource extends JsonResource
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
            'images' => data_get($this->images, '*.url'),
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'created_by' => blank($created_by) ? '---' : $created_by,
            'created_date' => Carbon::parse($this->created_at)->longRelativeDiffForHumans(),
        ];
    }
}
