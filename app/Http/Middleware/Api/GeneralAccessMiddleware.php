<?php

namespace App\Http\Middleware\Api;

use App\Http\Resources\Api\GeneralResource;
use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;

class GeneralAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->header('token');

        if (ApiToken::query()->where('token', $token)->where('is_active', true)->first()) {
            return $next($request);
        }

        return response()->json(GeneralResource::make([
            'message' => 'You do not have access!',
            'token' => $token,
        ]), 403);
    }
}
