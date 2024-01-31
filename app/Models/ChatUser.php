<?php

namespace App\Models;

use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\SoftDeleteAcceptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatUser extends Model
{
    use SoftDeletes, ActionBy, CreatedBy, SoftDeleteAcceptable;

    protected $fillable = [
        'chat_id',
        'user_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
