<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Requests\Api\Site\Comment\CommentStoreRequest;
use App\Http\Resources\Api\Site\Blog\BlogResource;
use App\Http\Resources\Api\Site\Blog\BlogsResource;
use App\Http\Resources\Api\Site\Comments\CommentsResource;
use App\Models\Blog;
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
        $data = $request->validated();

        $items = Blog::query()
            ->with(['created_user', 'media', 'comments'])
            ->withCount('comments')
            ->orderByDesc('id')
            ->paginate($data['limit'] ?? 10);

        return BlogsResource::collection($items);
    }

    public function show(Blog $blog): BlogResource
    {
        $blog->load('comments');

        return BlogResource::make($blog);
    }

    public function addComment(CommentStoreRequest $request, Blog $blog): AnonymousResourceCollection
    {
        $blog->comments()->create($request->validated());

        return CommentsResource::collection($blog->comments);
    }
}
