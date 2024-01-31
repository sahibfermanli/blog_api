<?php

namespace App\Services;

use App\Http\Resources\Api\Admin\UsersResource;
use App\Http\Resources\Api\GeneralResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class BlogUsersService
{
    private static ?BlogUsersService $instance = null;

    private function __construct() {

    }

    public static function instance(): BlogUsersService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAllUsers(array $data, bool $onlyActives = false): AnonymousResourceCollection
    {
        $items = User::query()
            ->when($onlyActives, function ($query) {
                $query->active();
            })
            ->withCount('comments')
            ->withCount('blogs')
            ->orderByDesc('id')
            ->paginate($data['limit'] ?? 10);

        return UsersResource::collection($items);
    }

    public function changeActiveStatus(User $user): JsonResponse
    {
        $old_is_active = $user->is_active;

        $user->update(['is_active' => DB::raw('!is_active')]);

        if ($old_is_active) {
            // delete blogs and comments
            $user->blogs()->delete();
            $user->comments()->delete();
        }

        return response()->json(GeneralResource::make([
            'message' => 'Status changed successfully!',
        ]));
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(GeneralResource::make([
            'message' => 'Selected item deleted successfully!',
        ]));
    }

    public function allUsersCount(bool $onlyActives = false): int
    {
        return User::query()
            ->when($onlyActives, function ($query) {
                $query->active();
            })
            ->count();
    }
}
