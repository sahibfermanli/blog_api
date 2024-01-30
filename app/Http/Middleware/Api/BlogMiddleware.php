<?php

namespace App\Http\Middleware\Api;

use App\Http\Resources\Api\GeneralResource;
use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;

class BlogMiddleware
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
        $blog = $request->route()?->parameter('blog');

        if ($blog && $blog->created_by !== auth()->user()->id) {
            return response()->json(GeneralResource::make([
                'message' => 'You do not have access!',
            ]), 403);
        }

        return $next($request);
    }
}
