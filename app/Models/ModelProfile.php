<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'height_cm',
        'style_tags',
        'experience_level',
        'available_note',
        'portfolio_url',
        'instagram_account',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
