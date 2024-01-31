<?php

namespace App\Services;

use App\Http\Resources\Api\Site\UserResource;
use App\Models\User;

class UserService
{
    private static ?UserService $instance = null;

    private function __construct() {

    }

    public static function instance(): UserService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function create_token(User $user, $device_type): UserResource
    {
        $user->token = $user->createToken($device_type)->plainTextToken;

        return new UserResource($user);
    }
}
