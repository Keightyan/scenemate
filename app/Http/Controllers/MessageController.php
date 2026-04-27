<?php

namespace App\Http\Controllers;

use App\Mail\NewMessageReceived;
use App\Models\Post;
use App\Models\Thread;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $threads = Thread::with(['post', 'userA', 'userB', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->where('user_a_id', $user->id)
            ->orWhere('user_b_id', $user->id)
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('messages.index', compact('threads', 'user'));
    }

    public function show(Request $request, Thread $thread): View|RedirectResponse
    {
        $user = $request->user();

        if (!$thread->isParticipant($user)) {
            abort(403);
        }

        $this->markRead($thread, $user);

        $thread->load(['post', 'userA', 'userB', 'messages.sender']);
        return view('messages.show', compact('thread', 'user'));
    }

    public function startThread(Request $request, Post $post): RedirectResponse
    {
        $user = $request->user();

        if (!$post->canMessageBy($user)) {
            return back()->with('info', 'このポストへのメッセージ送信条件を満たしていません。');
        }

        [$userAId, $userBId] = $user->id < $post->owner_user_id
            ? [$user->id, $post->owner_user_id]
            : [$post->owner_user_id, $user->id];

        $thread = Thread::firstOrCreate(
            ['post_id' => $post->id, 'user_a_id' => $userAId, 'user_b_id' => $userBId],
        );

        $this->markRead($thread, $user);

        return redirect()->route('messages.show', $thread);
    }

    public function store(Request $request, Thread $thread): RedirectResponse
    {
        $user = $request->user();

        if (!$thread->isParticipant($user)) {
            abort(403);
        }

        $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $message = $thread->messages()->create([
            'sender_id' => $user->id,
            'body' => $request->body,
            'created_at' => now(),
        ]);

        $thread->update(['last_message_at' => $message->created_at]);
        $this->markRead($thread, $user);

        $recipient = $thread->getOtherUser($user);
        $message->load('sender');
        Mail::to($recipient->email)->send(new NewMessageReceived($message, $thread, $recipient));

        return redirect()->route('messages.show', $thread);
    }

    public function markRead(Thread $thread, $user): void
    {
        $field = $thread->user_a_id === $user->id ? 'user_a_last_read_at' : 'user_b_last_read_at';
        $thread->update([$field => now()]);
    }

    public function markReadRoute(Request $request, Thread $thread): RedirectResponse
    {
        if (!$thread->isParticipant($request->user())) {
            abort(403);
        }
        $this->markRead($thread, $request->user());
        return back();
    }
}
