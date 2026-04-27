<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'target_gender' => ['required', Rule::in(['female', 'male', 'other', 'any'])],
            'target_age_min' => ['nullable', 'integer', 'min:0', 'max:120'],
            'target_age_max' => ['nullable', 'integer', 'min:0', 'max:120', 'gte:target_age_min'],
            'location_prefecture' => ['nullable', 'string', 'max:20'],
            'location_detail' => ['nullable', 'string', 'max:255'],
            'date_note' => ['nullable', 'string', 'max:255'],
            'reward_note' => ['nullable', 'string', 'max:255'],
            'target_role' => ['nullable', Rule::in(['model', 'photographer'])],
        ];
    }
}
