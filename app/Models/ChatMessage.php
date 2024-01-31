<?php

namespace App\Models;

use App\Events\PrivateChat;
use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\SoftDeleteAcceptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $receiver_id
 * @property mixed $message
 */
class ChatMessage extends Model
{
    use SoftDeletes, ActionBy, CreatedBy, SoftDeleteAcceptable;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'receiver_id',
        'message',
        'read_at',
        'created_by',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::created(static function ($model) {
            broadcast(new PrivateChat($model));
        });
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chat_id');
    }
}
