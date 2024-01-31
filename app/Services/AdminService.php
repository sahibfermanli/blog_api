<?php

namespace App\Services;

use App\Http\Resources\Api\Admin\UserResource;
use App\Models\Admin;

class AdminService
{
    private static ?AdminService $instance = null;

    private function __construct() {

    }

    public static function instance(): AdminService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function create_token(Admin $user, $device_type): UserResource
    {
        $user->token = $user->createToken($device_type)->plainTextToken;

        return new UserResource($user);
    }
}
