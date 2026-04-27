<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Thread;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'username',
        'avatar_path',
        'bio',
        'gender',
        'birth_date',
        'prefecture',
        'city',
        'status',
        'current_mode',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function cameramanProfile(): HasOne
    {
        return $this->hasOne(CameramanProfile::class);
    }

    public function modelProfile(): HasOne
    {
        return $this->hasOne(ModelProfile::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'owner_user_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'from_user_id');
    }

    public function cameramanPhotos(): HasMany
    {
        return $this->hasMany(ProfilePhoto::class)->where('type', 'cameraman')->orderBy('sort_order');
    }

    public function modelPhotos(): HasMany
    {
        return $this->hasMany(ProfilePhoto::class)->where('type', 'model')->orderBy('sort_order');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(UserBlock::class, 'blocker_user_id');
    }

    public function hasRole(string $key): bool
    {
        return $this->roles()->where('key', $key)->exists();
    }

    public function isPhotographer(): bool
    {
        return $this->hasRole('photographer');
    }

    public function isModel(): bool
    {
        return $this->hasRole('model');
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function isBlockedBy(User $user): bool
    {
        return UserBlock::where('blocker_user_id', $user->id)
            ->where('blocked_user_id', $this->id)
            ->exists();
    }

    public function hasBlocked(User $user): bool
    {
        return UserBlock::where('blocker_user_id', $this->id)
            ->where('blocked_user_id', $user->id)
            ->exists();
    }

    public function hasUnreadMessages(): bool
    {
        return Thread::where(function ($q) {
            $q->where('user_a_id', $this->id)
              ->where(function ($q2) {
                  $q2->whereNull('user_a_last_read_at')
                     ->orWhereColumn('last_message_at', '>', 'user_a_last_read_at');
              });
        })->orWhere(function ($q) {
            $q->where('user_b_id', $this->id)
              ->where(function ($q2) {
                  $q2->whereNull('user_b_last_read_at')
                     ->orWhereColumn('last_message_at', '>', 'user_b_last_read_at');
              });
        })->exists();
    }
}
