<?php

namespace App\Traits;

trait IsActive
{
    public function scopeActive($query): void
    {
        $query->where('is_active', true);
    }
}
