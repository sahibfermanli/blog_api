<?php

namespace App\Services;

use App\Http\Resources\Api\GeneralResource;
use App\Http\Resources\Api\Site\Blog\BlogResource;
use App\Http\Resources\Api\Site\Blog\BlogsResource;
use App\Http\Resources\Api\Site\Blog\BlogsStatisticsResource;
use App\Http\Resources\Api\Site\Blog\MyBlogResource;
use App\Http\Resources\Api\Site\Comments\CommentsResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;

class BlogService
{
    private static ?BlogService $instance = null;

    private function __construct() {

    }

    public static function instance(): BlogService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAllBlogs(array $data, bool $onlyMyBlogs = false, bool $onlyActives = false): AnonymousResourceCollection
    {
        $items = Blog::query()
            ->when($onlyMyBlogs, function ($query) {
                $query->where('created_by', auth()->user()->id);
            })
            ->when($onlyActives, function ($query) {
                $query->active();
            })
            ->with(['created_user', 'media', 'comments'])
            ->withCount('comments')
            ->orderByDesc('id')
            ->paginate($data['limit'] ?? 10);

        return BlogsResource::collection($items);
    }

    public function showBlog(Blog $blog, $withComments = false): BlogResource
    {
        if ($withComments) {
            $blog->load('comments');
        }

        return BlogResource::make($blog);
    }

    public function showMyBlog(Blog $blog, $withComments = false): MyBlogResource
    {
        if ($withComments) {
            $blog->load('comments');
        }

        return MyBlogResource::make($blog);
    }

    public function addComment(Blog $blog, array $data): void
    {
        $blog->comments()->create($data);
    }

    public function getComments(Blog $blog): AnonymousResourceCollection
    {
        return CommentsResource::collection($blog->comments);
    }

    public function store(FormRequest $request): JsonResponse
    {
        $blog = Blog::query()->create($request->validated());

        $file_upload = FileUpload::multipleUpload($request, 'images', 'blogs', $blog);

        return response()->json(GeneralResource::make([
            'message' => 'New item added successfully!' . $file_upload,
        ]));
    }

    public function update(FormRequest $request, Blog $blog): JsonResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = false;

        $blog->update($validated);

        $file_upload = FileUpload::multipleUpload($request, 'images', 'blogs', $blog);

        return response()->json(GeneralResource::make([
            'message' => 'Selected item updated successfully!' . $file_upload,
        ]));
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return response()->json(GeneralResource::make([
            'message' => 'Selected item deleted successfully!',
        ]));
    }

    /**
     * @throws MediaCannotBeDeleted
     */
    public function destroyImage(Blog $blog, int $media_id): JsonResponse
    {
        $blog->deleteMedia($media_id);
        $blog->update(['is_active' => false]);

        return response()->json(GeneralResource::make([
            'message' => 'Selected media file deleted successfully!',
        ]));
    }

    public function changeActiveStatus(Blog $blog): JsonResponse
    {
        $blog->update(['is_active' => DB::raw('!is_active')]);

        return response()->json(GeneralResource::make([
            'message' => 'Status changed successfully!',
        ]));
    }

    public function allBlogsCount(bool $onlyActives = false): int
    {
        return Blog::query()
            ->when($onlyActives, function ($query) {
                $query->active();
            })
            ->count();
    }

    public function getTopCommentedBlogs(int $limit = 5, bool $onlyActives = false): AnonymousResourceCollection
    {
        $items = Blog::query()
            ->when($onlyActives, function ($query) {
                $query->active();
            })
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->take($limit)
            ->get();

        return BlogsStatisticsResource::collection($items);
    }
}
