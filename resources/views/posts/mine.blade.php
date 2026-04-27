<x-layouts.app>
    <x-slot:title>自分の募集 - SceneMate</x-slot:title>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">自分の募集</h1>
        <a href="{{ route('posts.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            + 新規投稿
        </a>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-16">
            <p class="text-gray-400 mb-4">まだ募集を投稿していません。</p>
            <a href="{{ route('posts.create') }}"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                募集を投稿する
            </a>
        </div>
    @else
        <div class="space-y-3 mb-8">
            @foreach($posts as $post)
                <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $post->target_role === 'model' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $post->target_role === 'model' ? 'モデル募集' : 'カメラマン募集' }}
                            </span>
                            @if(!$post->is_open)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">非公開</span>
                            @endif
                        </div>
                        <a href="{{ route('posts.show', $post) }}" class="font-medium hover:text-indigo-600 block truncate">
                            {{ $post->title }}
                        </a>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $post->created_at->format('Y/m/d') }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="text-sm border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-50">編集</a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('削除しますか？')"
                                class="text-sm border border-red-200 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-50">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $posts->links() }}
    @endif
</x-layouts.app>
