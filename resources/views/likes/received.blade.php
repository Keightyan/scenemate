<x-layouts.app>
    <x-slot:title>もらったいいね - SceneMate</x-slot:title>

    <div class="flex items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold">もらったいいね</h1>
        <a href="{{ route('likes.sent') }}" class="text-sm text-indigo-600 hover:underline">← ブックマーク</a>
    </div>

    @if($likes->isEmpty())
        <p class="text-center text-gray-400 py-16">まだいいねがありません。</p>
    @else
        <div class="space-y-3 mb-8">
            @foreach($likes as $like)
                <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden shrink-0">
                        @if($like->user?->avatar_path)
                            <img src="{{ asset('storage/' . $like->user->avatar_path) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <span>👤</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium">
                            {{ $like->user?->username ?? $like->user?->email ?? '(退会済み)' }}
                        </p>
                        @if($like->post)
                            <p class="text-xs text-gray-400 truncate">
                                「<a href="{{ route('posts.show', $like->post) }}" class="hover:text-indigo-600">{{ $like->post->title }}</a>」にいいね
                            </p>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 shrink-0">
                        {{ $like->created_at?->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        </div>
        {{ $likes->links() }}
    @endif
</x-layouts.app>
