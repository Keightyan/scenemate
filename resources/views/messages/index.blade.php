<x-layouts.app>
    <x-slot:title>メッセージ - SceneMate</x-slot:title>

    <h1 class="text-2xl font-bold mb-6">メッセージ</h1>

    @if($threads->isEmpty())
        <p class="text-center text-gray-400 py-16">メッセージはまだありません。</p>
    @else
        <div class="space-y-2 mb-8">
            @foreach($threads as $thread)
                @php $other = $thread->getOtherUser($user); $unread = $thread->getUnreadCountFor($user); @endphp
                <a href="{{ route('messages.show', $thread) }}"
                    class="flex items-center gap-4 bg-white border border-gray-200 rounded-xl p-4 hover:shadow-sm transition
                        {{ $unread > 0 ? 'border-indigo-200 bg-indigo-50/30' : '' }}">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center shrink-0 overflow-hidden">
                        @if($other->avatar_path)
                            <img src="{{ asset('storage/' . $other->avatar_path) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <span>👤</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-sm">{{ $other->username ?? $other->email }}</p>
                            @if($unread > 0)
                                <span class="text-xs bg-indigo-600 text-white px-1.5 py-0.5 rounded-full">{{ $unread }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 truncate">
                            {{ $thread->post->title ?? '（削除された募集）' }}
                        </p>
                        @if($thread->messages->isNotEmpty())
                            <p class="text-xs text-gray-500 truncate mt-0.5">
                                {{ $thread->messages->last()->body }}
                            </p>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 shrink-0">
                        {{ $thread->last_message_at?->diffForHumans() }}
                    </p>
                </a>
            @endforeach
        </div>
        {{ $threads->links() }}
    @endif
</x-layouts.app>
