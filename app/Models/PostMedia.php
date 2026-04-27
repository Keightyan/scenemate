<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id', 'media_type', 'path', 'sort_order'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
