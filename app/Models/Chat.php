<?php

namespace App\Models;

use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\SoftDeleteAcceptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes, ActionBy, CreatedBy, SoftDeleteAcceptable;

    protected $fillable = [
        'uuid',
        'created_by',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ChatUser::class)
            ->whereNull('chat_users.deleted_at');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderByDesc('chat_messages.id');
    }

    public function unReadMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)
            ->where('chat_messages.sender_id', '!=', auth()->user()->id)
            ->whereNull('chat_messages.read_at');
    }
}
