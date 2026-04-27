<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CameramanProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'experience_level',
        'equipment',
        'genres',
        'price_note',
        'portfolio_url',
        'instagram_account',
        'can_shoot_photo',
        'can_shoot_video',
    ];

    protected function casts(): array
    {
        return [
            'can_shoot_photo' => 'boolean',
            'can_shoot_video' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
