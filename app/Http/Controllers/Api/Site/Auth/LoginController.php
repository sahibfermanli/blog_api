<?php

namespace App\Http\Controllers\Api\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Site\Auth\LoginRequest;
use App\Http\Resources\Api\GeneralResource;
use App\Http\Resources\Api\Site\UserResource;
use App\Http\Services\Site\UserService;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    public function login(LoginRequest $request): UserResource
    {
        $fields = $request->validated();

        $user = User::query()
            ->where('email', $fields['email'])
            ->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Invalid email or password!'
            ], 401));
        }

        return UserService::instance()->create_token($user, $fields['device_type']);
    }

    public function change_password(ChangePasswordRequest $request): GeneralResource
    {
        auth()->user()->update($request->validated());

        $current_token_id = auth()->user()->currentAccessToken()->id ?? 0;

        PersonalAccessToken::query()
            ->where('tokenable_id', auth()->id())
            ->where('tokenable_type', User::class)
            ->where('id', '<>', $current_token_id)
            ->delete();

        return GeneralResource::make([
            'message' => 'Your password has been changed! You are logged out of other devices.',
        ]);
    }

    public function check_logged_in(): JsonResponse
    {
        return response()->json([
            'message' => 'LoggedIn',
        ]);
    }
}
