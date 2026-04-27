<x-layouts.app>
    <x-slot:title>SceneMate - カメラマン・モデルのマッチングサービス</x-slot:title>

    {{-- ヒーロー --}}
    <section class="text-center py-14">
        <h1 class="text-4xl font-bold mb-4">カメラマンとモデルをつなぐ</h1>
        <p class="text-gray-500 mb-8 text-lg">撮影パートナーを探して、理想の写真を一緒に作ろう。</p>
        <div class="flex flex-wrap justify-center gap-3">
            @php $mode = auth()->user()?->current_mode; @endphp
            @if(!$mode || $mode === 'model')
                <a href="{{ route('posts.index', ['target' => 'model']) }}"
                    class="bg-white text-indigo-600 border border-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 font-medium">
                    モデル募集を見る
                </a>
            @endif
            @if(!$mode || $mode === 'photographer')
                <a href="{{ route('posts.index', ['target' => 'photographer']) }}"
                    class="bg-white text-indigo-600 border border-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 font-medium">
                    カメラマン募集を見る
                </a>
            @endif
            @auth
                <a href="{{ route('posts.create') }}"
                    class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 font-medium">
                    + 募集を投稿する
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 font-medium">
                    + 募集を投稿する
                </a>
            @endauth
        </div>
    </section>

    {{-- 3ステップ概要 --}}
    <section class="mb-14">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center">
                <div class="text-3xl mb-2">📝</div>
                <p class="font-semibold mb-1">1. 登録する</p>
                <p class="text-xs text-gray-500">メールアドレスだけで無料登録。カメラマン・モデルのロールを選びます。</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center">
                <div class="text-3xl mb-2">🔍</div>
                <p class="font-semibold mb-1">2. 募集を探す・投稿する</p>
                <p class="text-xs text-gray-500">気になる募集を見つけてメッセージ。自分で募集を出すこともできます。</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center">
                <div class="text-3xl mb-2">📸</div>
                <p class="font-semibold mb-1">3. 撮影する</p>
                <p class="text-xs text-gray-500">メッセージで予定を調整して、理想の撮影を実現しましょう。</p>
            </div>
        </div>
        <p class="text-center text-sm">
            <a href="{{ route('guide') }}" class="text-indigo-600 hover:underline">詳しい使い方・よくある質問はこちら</a>
        </p>
    </section>

    {{-- 最新募集 --}}
    <section>
        <h2 class="text-xl font-semibold mb-4">最新の募集</h2>
        @if($posts->isEmpty())
            <p class="text-gray-400 text-center py-12">まだ募集がありません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post) }}"
                        class="block bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $post->target_role === 'model' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $post->target_role === 'model' ? 'モデル募集' : 'カメラマン募集' }}
                            </span>
                            @if($post->location_prefecture)
                                <span class="text-xs text-gray-400">{{ $post->location_prefecture }}</span>
                            @endif
                        </div>
                        <h3 class="font-medium text-sm line-clamp-2 mb-2">{{ $post->title }}</h3>
                        <p class="text-xs text-gray-400">{{ $post->owner->username ?? $post->owner->email }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
