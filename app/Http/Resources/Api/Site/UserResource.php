<?php

namespace App\Http\Resources\Api\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $token
 * @property mixed $email
 * @property mixed $id
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
        ];
    }

    public function with($request): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
