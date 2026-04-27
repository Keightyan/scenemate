<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModeController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'mode' => ['required', 'in:photographer,model'],
        ]);

        $user = $request->user();

        if (!$user->hasRole($request->mode)) {
            $label = $request->mode === 'photographer' ? 'カメラマン' : 'モデル';
            return back()->withErrors(['mode' => "{$label}ロールが設定されていません。"]);
        }

        $user->update(['current_mode' => $request->mode]);

        return back()->with('success', 'モードを切り替えました。');
    }
}
