<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = ['from_user_id', 'post_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
