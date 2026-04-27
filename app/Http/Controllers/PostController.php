<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = auth()->user();
        $mode = $user?->current_mode;

        if ($mode) {
            $target = $mode;
            if ($request->query('target') && $request->query('target') !== $mode) {
                return redirect()->route('posts.index', ['target' => $mode]);
            }
        } else {
            $target = $request->query('target', 'model');
        }

        $query = Post::with('owner')->open()->forRole($target)->latest();

        if ($request->filled('prefecture')) {
            $query->where('location_prefecture', $request->prefecture);
        }

        $posts = $query->paginate(20)->withQueryString();

        return view('posts.index', compact('posts', 'target'));
    }

    public function show(Post $post): View|RedirectResponse
    {
        $user = auth()->user();
        $mode = $user?->current_mode;

        if ($mode && $post->target_role !== $mode) {
            return redirect()->route('posts.index', ['target' => $mode])
                ->with('info', 'このページは閲覧できません。');
        }

        $post->load(['owner.cameramanProfile', 'owner.modelProfile', 'media']);
        $liked = $user ? $post->isLikedBy($user) : false;
        $canMessage = $user ? $post->canMessageBy($user) : false;

        return view('posts.show', compact('post', 'liked', 'canMessage'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if (!$user->current_mode) {
            return redirect()->route('settings.roles.edit')->with('info', 'まずロールを設定してください。');
        }
        $user->loadMissing('roles');
        $defaultTarget = $user->current_mode === 'photographer' ? 'model' : 'photographer';
        return view('posts.create', [
            'mode'          => $user->current_mode,
            'defaultTarget' => $defaultTarget,
            'hasBothRoles'  => $user->roles->count() > 1,
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $targetRole = $data['target_role'] ?? ($user->current_mode === 'photographer' ? 'model' : 'photographer');

        $post = Post::create(array_merge(
            collect($data)->except('target_role')->all(),
            [
                'owner_user_id' => $user->id,
                'owner_role'    => $user->current_mode,
                'target_role'   => $targetRole,
            ]
        ));

        return redirect()->route('posts.show', $post)->with('success', '募集を投稿しました。');
    }

    public function mine(Request $request): View
    {
        $posts = Post::where('owner_user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('posts.mine', compact('posts'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $post->update($request->validated());

        return redirect()->route('posts.show', $post)->with('success', '募集を更新しました。');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.mine')->with('success', '募集を削除しました。');
    }
}
