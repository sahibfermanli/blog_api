<?php

namespace App\Models;

use App\Casts\Blog\ImagesCast;
use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\IsActive;
use App\Traits\SoftDeleteAcceptable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model  implements HasMedia
{
    use SoftDeletes, IsActive, ActionBy, CreatedBy, SoftDeleteAcceptable, CascadeSoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'body',
        'is_active',
        'created_by',
    ];

    protected array $cascadeDeletes = ['media'];

    protected $casts = [
        'images' => ImagesCast::class,
    ];

    //protected array $softDeleteAcceptableRelations = ['comments'];
}
