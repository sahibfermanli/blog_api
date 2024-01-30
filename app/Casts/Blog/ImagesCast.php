<?php

namespace App\Casts\Blog;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ImagesCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        $images = [];

        if ($model->hasMedia('blogs')) {
            foreach ($model->getMedia('blogs') as $media) {
                $images[] = [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                ];
            }
        }

        return $images;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return bool
     */
    public function set($model, string $key, $value, array $attributes): bool
    {
        return false;
    }
}
