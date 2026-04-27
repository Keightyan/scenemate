<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'blocked_user_id' => ['required', 'exists:users,id'],
        ]);

        $blockerId = $request->user()->id;
        $blockedId = $request->blocked_user_id;

        if ($blockerId === (int) $blockedId) {
            return back()->withErrors(['blocked_user_id' => '自分をブロックすることはできません。']);
        }

        UserBlock::firstOrCreate([
            'blocker_user_id' => $blockerId,
            'blocked_user_id' => $blockedId,
        ]);

        return back()->with('success', 'ユーザーをブロックしました。');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        UserBlock::where('blocker_user_id', $request->user()->id)
            ->where('blocked_user_id', $user->id)
            ->delete();

        return back()->with('success', 'ブロックを解除しました。');
    }
}
