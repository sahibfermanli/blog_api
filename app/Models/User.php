<?php

namespace App\Models;

use App\Casts\User\PasswordCast;
use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use App\Traits\IsActive;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property $store
 * @property string|mixed $token
 * @property mixed $is_active
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ActionBy, CreatedBy, CascadeSoftDeletes, IsActive;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'is_active',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => PasswordCast::class,
    ];

    protected array $cascadeDeletes = ['tokens', 'blogs', 'comments'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'created_by', 'id')->orderByDesc('comments.id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'created_by', 'id')->orderByDesc('blogs.id');
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, ChatUser::class)
            ->withPivot(['user_id'])
            ->whereNull('chat_users.deleted_at');
    }
}
