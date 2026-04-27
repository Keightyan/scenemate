<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LikeController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        if ($post->owner_user_id === $request->user()->id) {
            return back();
        }

        Like::firstOrCreate([
            'from_user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);

        return back()->with('success', 'ブックマークしました。');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        Like::where('from_user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->delete();

        return back()->with('success', 'ブックマークを解除しました。');
    }

    public function sent(Request $request): View
    {
        $likes = Like::with('post.owner')
            ->where('from_user_id', $request->user()->id)
            ->latest('created_at')
            ->paginate(20);

        return view('likes.sent', compact('likes'));
    }

    public function received(Request $request): View
    {
        $postIds = Post::where('owner_user_id', $request->user()->id)->pluck('id');

        $likes = Like::with(['post', 'user'])
            ->whereIn('post_id', $postIds)
            ->latest('created_at')
            ->paginate(20);

        return view('likes.received', compact('likes'));
    }
}
