<x-layouts.app>
    <x-slot:title>メッセージ詳細 - SceneMate</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <div class="mb-4 flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-sm text-indigo-600 hover:underline">← メッセージ一覧</a>
            @if($thread->post)
                <span class="text-gray-300">|</span>
                <a href="{{ route('posts.show', $thread->post) }}" class="text-sm text-gray-500 hover:text-indigo-600 truncate max-w-xs">
                    {{ $thread->post->title }}
                </a>
            @endif
        </div>

        {{-- メッセージ一覧 --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
            <div class="border-b border-gray-100 px-4 py-3">
                @php $other = $thread->getOtherUser($user); @endphp
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full overflow-hidden">
                        @if($other->avatar_path)
                            <img src="{{ asset('storage/' . $other->avatar_path) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs">👤</div>
                        @endif
                    </div>
                    <a href="{{ route('users.show', $other) }}" class="font-medium text-sm hover:text-indigo-600">
                        {{ $other->username ?? $other->email }}
                    </a>
                </div>
            </div>

            <div class="p-4 space-y-4 max-h-96 overflow-y-auto" id="messages-container">
                @foreach($thread->messages as $message)
                    @php $isMe = $message->sender_id === $user->id; @endphp
                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-sm {{ $isMe ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-900' }} rounded-xl px-4 py-2">
                            @if($message->subject)
                                <p class="text-xs {{ $isMe ? 'text-indigo-200' : 'text-gray-500' }} mb-1">{{ $message->subject }}</p>
                            @endif
                            <p class="text-sm whitespace-pre-wrap">{{ $message->body }}</p>
                            <p class="text-xs {{ $isMe ? 'text-indigo-200' : 'text-gray-400' }} mt-1">
                                {{ $message->created_at?->format('m/d H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 返信フォーム --}}
        <form method="POST" action="{{ route('messages.store', $thread) }}"
            class="bg-white border border-gray-200 rounded-xl p-4">
            @csrf
            <div class="flex gap-3">
                <textarea name="body" rows="2" required placeholder="メッセージを入力..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none
                        @error('body') border-red-400 @enderror"></textarea>
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 self-end">
                    送信
                </button>
            </div>
            @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </form>
    </div>

    <script>
        const container = document.getElementById('messages-container');
        if (container) container.scrollTop = container.scrollHeight;
    </script>
</x-layouts.app>
