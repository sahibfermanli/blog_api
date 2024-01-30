<?php

namespace App\Traits;

/**
 * @method static creating(\Closure $param)
 * @method static updating(\Closure $param)
 * @method static deleted(\Closure $param)
 */
trait ActionBy
{
    public static function bootActionBy(): void
    {
        static::creating(static function ($model) {
            $model->created_by = auth()->user()->id ?? 0;
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->user()->id ?? 0;
        });

        static::deleted(static function ($model) {
            $model->deleted_by = auth()->user()->id ?? 0;
            $model->save();
        });
    }
}
