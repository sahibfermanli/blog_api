<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GeneralResource;
use App\Services\BlogService;
use App\Services\BlogUsersService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function index(): JsonResponse
    {
        $blogService = BlogService::instance();
        $userService = BlogUsersService::instance();

        return response()->json(GeneralResource::make([
            'all_blogs_count' => $blogService->allBlogsCount(),
            'active_blogs_count' => $blogService->allBlogsCount(true),
            'all_users_count' => $userService->allUsersCount(),
            'active_users_count' => $userService->allUsersCount(true),
            'top_commented_blogs' => $blogService->getTopCommentedBlogs(),
        ]));
    }
}
