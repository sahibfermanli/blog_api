<?php

namespace App\Http\Controllers\Api\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\Auth\RegisterRequest;
use App\Http\Resources\Api\Site\UserResource;
use App\Http\Services\Site\UserService;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): UserResource
    {
        $fields = $request->validated();

        $user = User::query()->create($fields);

        return UserService::instance()->create_token($user, $fields['device_type']);
    }
}
