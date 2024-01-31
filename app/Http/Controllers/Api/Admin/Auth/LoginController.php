<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Admin\Auth\LoginRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Http\Resources\Api\GeneralResource;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    public function login(LoginRequest $request): UserResource
    {
        $fields = $request->validated();

        $user = Admin::query()
            ->where('email', $fields['email'])
            ->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Invalid email or password!'
            ], 401));
        }

        return AdminService::instance()->create_token($user, $fields['device_type']);
    }

    public function change_password(ChangePasswordRequest $request): GeneralResource
    {
        auth()->user()->update($request->validated());

        $current_token_id = auth()->user()->currentAccessToken()->id ?? 0;

        PersonalAccessToken::query()
            ->where('tokenable_id', auth()->id())
            ->where('tokenable_type', Admin::class)
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
