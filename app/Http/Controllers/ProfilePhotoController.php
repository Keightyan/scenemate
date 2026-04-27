<?php

namespace App\Http\Controllers;

use App\Models\ProfilePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilePhotoController extends Controller
{
    private const MAX_PHOTOS = 6;

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:40960'],
            'type'  => ['required', Rule::in(['cameraman', 'model'])],
        ]);

        $user = $request->user();
        $type = $request->type;

        $count = ProfilePhoto::where('user_id', $user->id)->where('type', $type)->count();
        if ($count >= self::MAX_PHOTOS) {
            return back()->withErrors(['photo_' . $type => '写真は最大' . self::MAX_PHOTOS . '枚まで登録できます。']);
        }

        $path = $request->file('photo')->store("profile_photos/{$user->id}", 'public');

        ProfilePhoto::create([
            'user_id'    => $user->id,
            'type'       => $type,
            'file_path'  => $path,
            'sort_order' => $count,
        ]);

        return back()->with('success', '写真を追加しました。');
    }

    public function destroy(Request $request, ProfilePhoto $photo): RedirectResponse
    {
        abort_if($photo->user_id !== $request->user()->id, 403);

        Storage::disk('public')->delete($photo->file_path);
        $photo->delete();

        return back()->with('success', '写真を削除しました。');
    }
}
