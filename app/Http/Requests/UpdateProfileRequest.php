<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($this->user()->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'gender' => ['nullable', Rule::in(['female', 'male', 'other', 'prefer_not'])],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'prefecture' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:50'],
            // cameraman
            'experience_level_cam' => ['nullable', Rule::in(['beginner', 'intermediate', 'pro'])],
            'equipment' => ['nullable', 'string', 'max:1000'],
            'genres' => ['nullable', 'string', 'max:500'],
            'price_note' => ['nullable', 'string', 'max:1000'],
            'portfolio_url_cam' => ['nullable', 'url', 'max:255'],
            'instagram_account_cam' => ['nullable', 'string', 'max:100', 'regex:/^@?[\w.]+$/'],
            'can_shoot_photo' => ['nullable', 'boolean'],
            'can_shoot_video' => ['nullable', 'boolean'],
            // model
            'height_cm' => ['nullable', 'integer', 'min:100', 'max:250'],
            'style_tags' => ['nullable', 'string', 'max:500'],
            'experience_level_mod' => ['nullable', Rule::in(['beginner', 'intermediate', 'pro'])],
            'available_note' => ['nullable', 'string', 'max:500'],
            'portfolio_url_mod' => ['nullable', 'url', 'max:255'],
            'instagram_account_mod' => ['nullable', 'string', 'max:100', 'regex:/^@?[\w.]+$/'],
        ];
    }
}
