<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Requests\Api\Site\Blog\BlogStoreRequest;
use App\Http\Resources\Api\Site\Blog\MyBlogResource;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;

class MyBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GeneralListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GeneralListRequest $request): AnonymousResourceCollection
    {
        return BlogService::instance()->getAllBlogs($request->validated(), true);
    }

    public function show(Blog $blog): MyBlogResource
    {
        return BlogService::instance()->showMyBlog($blog);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogStoreRequest $request
     * @return JsonResponse
     */
    public function store(BlogStoreRequest $request): JsonResponse
    {
        return BlogService::instance()->store($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogStoreRequest $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(BlogStoreRequest $request, Blog $blog): JsonResponse
    {
        return BlogService::instance()->update($request, $blog);
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

    /**
     * @throws MediaCannotBeDeleted
     */
    public function destroyImage(Blog $blog, $media_id): JsonResponse
    {
        return BlogService::instance()->destroyImage($blog, $media_id);
    }
}
