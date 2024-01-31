<?php

namespace App\Models;

use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\SoftDeleteAcceptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, ActionBy, CreatedBy, SoftDeleteAcceptable;

    protected $fillable = [
        'body',
        'blog_id',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
