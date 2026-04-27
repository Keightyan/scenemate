<x-layouts.app>
    <x-slot:title>ブックマーク一覧 - SceneMate</x-slot:title>

    <div class="flex items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold">ブックマーク</h1>
        <a href="{{ route('likes.received') }}" class="text-sm text-indigo-600 hover:underline">もらったいいね →</a>
    </div>

    @if($likes->isEmpty())
        <p class="text-center text-gray-400 py-16">ブックマークした募集はありません。</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($likes as $like)
                @if($like->post)
                    <a href="{{ route('posts.show', $like->post) }}"
                        class="block bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $like->post->target_role === 'model' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $like->post->target_role === 'model' ? 'モデル募集' : 'カメラマン募集' }}
                            </span>
                        </div>
                        <h3 class="font-medium text-sm mb-1 line-clamp-2">{{ $like->post->title }}</h3>
                        <p class="text-xs text-gray-400">{{ $like->post->owner->username ?? $like->post->owner->email }}</p>
                    </a>
                @endif
            @endforeach
        </div>
        {{ $likes->links() }}
    @endif
</x-layouts.app>
