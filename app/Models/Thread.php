<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    protected $fillable = [
        'post_id',
        'user_a_id',
        'user_b_id',
        'user_a_last_read_at',
        'user_b_last_read_at',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'user_a_last_read_at' => 'datetime',
            'user_b_last_read_at' => 'datetime',
            'last_message_at' => 'datetime',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function userA(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_a_id');
    }

    public function userB(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_b_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function getOtherUser(User $me): User
    {
        return $this->user_a_id === $me->id ? $this->userB : $this->userA;
    }

    public function isParticipant(User $user): bool
    {
        return $this->user_a_id === $user->id || $this->user_b_id === $user->id;
    }

    public function getUnreadCountFor(User $user): int
    {
        $lastRead = $this->user_a_id === $user->id
            ? $this->user_a_last_read_at
            : $this->user_b_last_read_at;

        $query = $this->messages()->where('sender_id', '!=', $user->id);
        if ($lastRead) {
            $query->where('created_at', '>', $lastRead);
        }
        return $query->count();
    }
}
