<x-layouts.app>
    <x-slot:title>{{ $post->title }} - SceneMate</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="text-sm text-indigo-600 hover:underline">← 一覧に戻る</a>
            @auth
                @if(auth()->id() === $post->owner_user_id)
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-sm border border-gray-300 px-4 py-1.5 rounded-lg hover:bg-gray-50">編集</a>
                @endif
            @endauth
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            {{-- バッジ --}}
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                <span class="text-sm px-3 py-1 rounded-full
                    {{ $post->target_role === 'model' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $post->target_role === 'model' ? 'モデル募集' : 'カメラマン募集' }}
                </span>
                @if(!$post->is_open)
                    <span class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-500">募集終了</span>
                @endif
            </div>

            <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>

            {{-- 詳細情報 --}}
            <dl class="grid grid-cols-2 gap-3 text-sm mb-6">
                @if($post->location_prefecture)
                    <div>
                        <dt class="text-gray-400 text-xs">エリア</dt>
                        <dd>{{ $post->location_prefecture }} {{ $post->location_detail }}</dd>
                    </div>
                @endif
                @if($post->date_note)
                    <div>
                        <dt class="text-gray-400 text-xs">日程</dt>
                        <dd>{{ $post->date_note }}</dd>
                    </div>
                @endif
                @if($post->reward_note)
                    <div>
                        <dt class="text-gray-400 text-xs">報酬・交通費</dt>
                        <dd>{{ $post->reward_note }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-gray-400 text-xs">対象性別</dt>
                    <dd>{{ ['female'=>'女性','male'=>'男性','other'=>'その他','any'=>'不問'][$post->target_gender] ?? $post->target_gender }}</dd>
                </div>
                @if($post->target_age_min || $post->target_age_max)
                    <div>
                        <dt class="text-gray-400 text-xs">対象年齢</dt>
                        <dd>{{ $post->target_age_min ?? '下限なし' }} 〜 {{ $post->target_age_max ?? '上限なし' }}歳</dd>
                    </div>
                @endif
            </dl>

            @if($post->description)
                <div class="prose prose-sm max-w-none mb-6">
                    <h3 class="font-medium text-base mb-2">詳細</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $post->description }}</p>
                </div>
            @endif

            {{-- いいね・メッセージ --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                @auth
                    @if(auth()->id() !== $post->owner_user_id)
                        @if($liked)
                            <form method="POST" action="{{ route('likes.destroy', $post) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="flex items-center gap-1 text-sm text-pink-600 border border-pink-300 px-4 py-2 rounded-lg hover:bg-pink-50">
                                    ♥ ブックマーク済
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('likes.store', $post) }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-1 text-sm text-gray-600 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">
                                    ♡ ブックマーク
                                </button>
                            </form>
                        @endif
                    @endif

                    @if($canMessage && $post->is_open)
                        <form method="POST" action="{{ route('messages.startThread', $post) }}">
                            @csrf
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                                メッセージを送る
                            </button>
                        </form>
                    @elseif(!$canMessage && auth()->id() !== $post->owner_user_id)
                        <p class="text-xs text-gray-400">このポストへのメッセージ送信条件を満たしていません</p>
                    @endif

                    {{-- 通報 --}}
                    @if(auth()->id() !== $post->owner_user_id)
                        <form method="POST" action="{{ route('reports.store') }}" class="ml-auto">
                            @csrf
                            <input type="hidden" name="reported_user_id" value="{{ $post->owner_user_id }}">
                            <input type="hidden" name="reason" value="不適切な募集">
                            <button type="submit" onclick="return confirm('このユーザーを通報しますか？')"
                                class="text-xs text-gray-400 hover:text-red-500">通報</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                        ログインしてメッセージを送る
                    </a>
                @endauth
            </div>
        </div>

        {{-- 投稿者プロフィール --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <h2 class="font-semibold mb-3">投稿者</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('users.show', $post->owner) }}" class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 overflow-hidden shrink-0 hover:opacity-80 transition">
                    @if($post->owner->avatar_path)
                        <img src="{{ asset('storage/' . $post->owner->avatar_path) }}" alt="avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-lg">👤</span>
                    @endif
                </a>
                <div>
                    <a href="{{ route('users.show', $post->owner) }}" class="font-medium hover:text-indigo-600">
                        {{ $post->owner->username ?? $post->owner->email }}
                    </a>
                    @if($post->owner->prefecture)
                        <p class="text-xs text-gray-400">{{ $post->owner->prefecture }}</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
