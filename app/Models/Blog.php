<?php

namespace App\Models;

use App\Casts\Blog\ImagesCast;
use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\IsActive;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property mixed $comments
 */
class Blog extends Model  implements HasMedia
{
    use SoftDeletes, IsActive, ActionBy, CreatedBy, CascadeSoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'body',
        'is_active',
        'created_by',
    ];

    protected array $cascadeDeletes = ['media', 'comments'];

    protected $casts = [
        'images' => ImagesCast::class,
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderByDesc('comments.id');
    }
}
