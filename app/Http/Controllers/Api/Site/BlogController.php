<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Requests\Api\Site\Comment\CommentStoreRequest;
use App\Http\Resources\Api\Site\Blog\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;
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
        return BlogService::instance()->getAllBlogs($request->validated(), false, true);
    }

    public function show(Blog $blog): BlogResource
    {
        return BlogService::instance()->showBlog($blog, true);
    }

    public function addComment(CommentStoreRequest $request, Blog $blog): AnonymousResourceCollection
    {
        $blogService = BlogService::instance();

        $blogService->addComment($blog, $request->validated());

        return $blogService->getComments($blog);
    }
}
