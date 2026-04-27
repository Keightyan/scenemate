<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function me(Request $request): View
    {
        $user = $request->user()->load(['roles', 'cameramanProfile', 'modelProfile', 'cameramanPhotos', 'modelPhotos']);
        return view('profile.me', compact('user'));
    }

    public function show(User $user): View
    {
        $user->load(['roles', 'cameramanProfile', 'modelProfile', 'cameramanPhotos', 'modelPhotos']);
        return view('users.show', compact('user'));
    }

    public function edit(Request $request): View
    {
        $user = $request->user()->load(['roles', 'cameramanProfile', 'modelProfile', 'cameramanPhotos', 'modelPhotos']);
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $cameramanData = array_intersect_key($data, array_flip([
            'experience_level_cam', 'equipment', 'genres', 'price_note',
            'portfolio_url_cam', 'instagram_account_cam', 'can_shoot_photo', 'can_shoot_video',
        ]));

        $modelData = array_intersect_key($data, array_flip([
            'height_cm', 'style_tags', 'experience_level_mod',
            'available_note', 'portfolio_url_mod', 'instagram_account_mod',
        ]));

        $userFields = array_intersect_key($data, array_flip([
            'username', 'bio', 'gender', 'birth_date', 'prefecture', 'city',
        ]));

        if ($user->gender) {
            unset($userFields['gender']);
        }
        if ($user->birth_date) {
            unset($userFields['birth_date']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $userFields['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userFields);

        if ($user->isPhotographer() && !empty($cameramanData)) {
            $profileData = [
                'experience_level' => $cameramanData['experience_level_cam'] ?? null,
                'equipment' => $cameramanData['equipment'] ?? null,
                'genres' => $cameramanData['genres'] ?? null,
                'price_note' => $cameramanData['price_note'] ?? null,
                'portfolio_url' => $cameramanData['portfolio_url_cam'] ?? null,
                'instagram_account' => ltrim($cameramanData['instagram_account_cam'] ?? '', '@') ?: null,
                'can_shoot_photo' => $cameramanData['can_shoot_photo'] ?? false,
                'can_shoot_video' => $cameramanData['can_shoot_video'] ?? false,
            ];
            $user->cameramanProfile()->updateOrCreate(['user_id' => $user->id], $profileData);
        }

        if ($user->isModel() && !empty($modelData)) {
            $profileData = [
                'height_cm' => $modelData['height_cm'] ?? null,
                'style_tags' => $modelData['style_tags'] ?? null,
                'experience_level' => $modelData['experience_level_mod'] ?? null,
                'available_note' => $modelData['available_note'] ?? null,
                'portfolio_url' => $modelData['portfolio_url_mod'] ?? null,
                'instagram_account' => ltrim($modelData['instagram_account_mod'] ?? '', '@') ?: null,
            ];
            $user->modelProfile()->updateOrCreate(['user_id' => $user->id], $profileData);
        }

        return redirect()->route('profile.me')->with('success', 'プロフィールを更新しました。');
    }
}
