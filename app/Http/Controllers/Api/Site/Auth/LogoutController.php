<?php

namespace App\Http\Controllers\Api\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GeneralResource;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(GeneralResource::make([
            'code' => 200,
            'message' => 'This device has been logged out!'
        ]));
    }

    public function logout_all(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(GeneralResource::make([
            'code' => 200,
            'message' => 'All devices have been logged out!'
        ]));
    }
}
