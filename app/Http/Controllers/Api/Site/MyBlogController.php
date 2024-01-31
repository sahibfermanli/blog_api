<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Http\Requests\Api\Site\Blog\BlogStoreRequest;
use App\Http\Resources\Api\GeneralResource;
use App\Http\Resources\Api\Site\Blog\MyBlogResource;
use App\Http\Resources\Api\Site\Blog\BlogsResource;
use App\Models\Blog;
use App\Services\FileUpload;
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
        $data = $request->validated();

        $items = Blog::query()
            ->where('created_by', auth()->user()->id)
            ->with(['created_user', 'media', 'comments'])
            ->withCount('comments')
            ->orderByDesc('id')
            ->paginate($data['limit'] ?? 10);

        return BlogsResource::collection($items);
    }

    public function show(Blog $blog): MyBlogResource
    {
        return MyBlogResource::make($blog);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogStoreRequest $request
     * @return JsonResponse
     */
    public function store(BlogStoreRequest $request): JsonResponse
    {
        $blog = Blog::query()->create($request->validated());

        $file_upload = FileUpload::multipleUpload($request, 'images', 'blogs', $blog);

        return response()->json(GeneralResource::make([
            'message' => 'New item added successfully!' . $file_upload,
        ]));
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
        $validated = $request->validated();
        $validated['is_active'] = false;

        $blog->update($validated);

        $file_upload = FileUpload::multipleUpload($request, 'images', 'blogs', $blog);

        return response()->json(GeneralResource::make([
            'message' => 'Selected item updated successfully!' . $file_upload,
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return JsonResponse
     */
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
    public function destroyImage(Blog $blog, $media_id): JsonResponse
    {
        $blog->deleteMedia($media_id);
        $blog->update(['is_active' => false]);

        return response()->json(GeneralResource::make([
            'message' => 'Selected media file deleted successfully!',
        ]));
    }
}
