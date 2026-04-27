<x-layouts.app>
    <x-slot:title>
        {{ $target === 'model' ? 'モデル募集一覧' : 'カメラマン募集一覧' }} - SceneMate
    </x-slot:title>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">
            {{ $target === 'model' ? 'モデル募集' : 'カメラマン募集' }}
        </h1>
        @auth
            <a href="{{ route('posts.create') }}"
                class="bg-pink-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-pink-600 font-medium">
                + 募集を投稿
            </a>
        @endauth
    </div>

    {{-- フィルタ --}}
    <form method="GET" action="{{ route('posts.index') }}" class="mb-6 flex gap-2">
        <input type="hidden" name="target" value="{{ $target }}">
        <input type="text" name="prefecture" value="{{ request('prefecture') }}"
            placeholder="都道府県で絞り込み"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 max-w-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">絞り込み</button>
        @if(request('prefecture'))
            <a href="{{ route('posts.index', ['target' => $target]) }}"
                class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">クリア</a>
        @endif
    </form>

    @if($posts->isEmpty())
        <p class="text-center text-gray-400 py-16">条件に合う募集が見つかりませんでした。</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}"
                    class="block bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $post->target_role === 'model' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $post->target_role === 'model' ? 'モデル募集' : 'カメラマン募集' }}
                        </span>
                        @if($post->location_prefecture)
                            <span class="text-xs text-gray-400">{{ $post->location_prefecture }}</span>
                        @endif
                    </div>
                    <h3 class="font-medium text-sm mb-2 line-clamp-2">{{ $post->title }}</h3>
                    @if($post->reward_note)
                        <p class="text-xs text-gray-500 mb-1">報酬: {{ $post->reward_note }}</p>
                    @endif
                    @if($post->date_note)
                        <p class="text-xs text-gray-500">日程: {{ $post->date_note }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">
                        {{ $post->owner->username ?? $post->owner->email }}
                        &middot; {{ $post->created_at->diffForHumans() }}
                    </p>
                </a>
            @endforeach
        </div>

        {{ $posts->links() }}
    @endif
</x-layouts.app>
