<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GeneralListRequest;
use App\Models\User;
use App\Services\BlogUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GeneralListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GeneralListRequest $request): AnonymousResourceCollection
    {
        return BlogUsersService::instance()->getAllUsers($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return BlogUsersService::instance()->destroy($user);
    }

    public function changeActiveStatus(User $user): JsonResponse
    {
        return BlogUsersService::instance()->changeActiveStatus($user);
    }
}
