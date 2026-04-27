<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'owner_user_id',
        'owner_role',
        'target_role',
        'target_gender',
        'target_age_min',
        'target_age_max',
        'title',
        'description',
        'location_prefecture',
        'location_detail',
        'date_note',
        'reward_note',
        'is_open',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
            'closed_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class)->orderBy('sort_order');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('is_open', true);
    }

    public function scopeForRole(Builder $query, string $role): Builder
    {
        return $query->where('target_role', $role);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('from_user_id', $user->id)->exists();
    }

    public function canMessageBy(User $user): bool
    {
        if ($user->id === $this->owner_user_id) {
            return false;
        }

        if ($user->current_mode !== $this->target_role) {
            return false;
        }

        if ($this->target_gender !== 'any' && $user->gender !== $this->target_gender) {
            return false;
        }

        $age = $user->age;
        if ($age !== null) {
            if ($this->target_age_min !== null && $age < $this->target_age_min) {
                return false;
            }
            if ($this->target_age_max !== null && $age > $this->target_age_max) {
                return false;
            }
        }

        if ($user->hasBlocked($this->owner) || $user->isBlockedBy($this->owner)) {
            return false;
        }

        return true;
    }
}
