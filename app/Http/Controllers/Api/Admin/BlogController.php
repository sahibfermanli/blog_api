<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Resources\Api\Site\Blog\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GeneralListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GeneralListRequest $request): AnonymousResourceCollection
    {
        return BlogService::instance()->getAllBlogs($request->validated());
    }

    public function show(Blog $blog): BlogResource
    {
        return BlogService::instance()->showBlog($blog, true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        return BlogService::instance()->destroy($blog);
    }

    public function changeActiveStatus(Blog $blog): JsonResponse
    {
        return BlogService::instance()->changeActiveStatus($blog);
    }
}
