<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method belongsTo(string $class, string $string)
 */
trait CreatedBy
{
    public function created_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
