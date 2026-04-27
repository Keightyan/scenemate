<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateRoles(Request $request): RedirectResponse
    {
        $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'in:photographer,model'],
        ]);

        $user = $request->user();
        $roles = Role::whereIn('key', $request->roles)->get();
        $user->roles()->sync($roles->pluck('id'));

        if (!in_array($user->current_mode, $request->roles)) {
            $user->update(['current_mode' => $request->roles[0]]);
        }

        foreach ($request->roles as $roleKey) {
            if ($roleKey === 'photographer' && !$user->cameramanProfile) {
                $user->cameramanProfile()->create(['user_id' => $user->id]);
            }
            if ($roleKey === 'model' && !$user->modelProfile) {
                $user->modelProfile()->create(['user_id' => $user->id]);
            }
        }

        return redirect()->route('profile.me')->with('success', 'ロールを更新しました。');
    }
}
