<x-layouts.app>
    <x-slot:title>使い方 - SceneMate</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-2">使い方</h1>
        <p class="text-gray-500 mb-10">SceneMateの使い方と、できることを説明します。</p>

        {{-- SceneMateとは --}}
        <section class="mb-12">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">SceneMateとは？</h2>
            <p class="text-gray-700 leading-relaxed">
                SceneMateは、<strong>カメラマン</strong>と<strong>モデル</strong>が撮影パートナーを探すためのマッチングサービスです。
                「一緒に撮影したい」という人同士が気軽に出会える場を提供します。
            </p>
        </section>

        {{-- 未登録ユーザー向け --}}
        <section class="mb-12">
            <h2 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">
                <span class="text-gray-400 text-base font-normal block mb-1">登録前でもできること</span>
                まずは眺めてみよう
            </h2>
            <div class="space-y-4">
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">👀</span>
                    <div>
                        <p class="font-medium">募集一覧・詳細を閲覧</p>
                        <p class="text-sm text-gray-500">ログインなしでモデル募集・カメラマン募集の一覧と詳細を見られます。どんな人が活動しているか確認してみてください。</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <span class="text-2xl">👤</span>
                    <div>
                        <p class="font-medium">ユーザープロフィールを閲覧</p>
                        <p class="text-sm text-gray-500">各ユーザーのプロフィール（経験・機材・スタイルなど）もログイン不要で確認できます。</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-indigo-50 border border-indigo-100 rounded-xl p-6">
                <h3 class="font-bold mb-4">登録から始める 3ステップ</h3>
                <ol class="space-y-4">
                    <li class="flex gap-4 items-start">
                        <span class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">1</span>
                        <div>
                            <p class="font-medium">メールアドレスで登録</p>
                            <p class="text-sm text-gray-500">メールアドレスとパスワードだけで登録できます。SNS連携は不要です。</p>
                        </div>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">2</span>
                        <div>
                            <p class="font-medium">ロールを設定する</p>
                            <p class="text-sm text-gray-500">「カメラマン」「モデル」のどちらか（または両方）を選びます。ロールによって専用のプロフィール項目が使えます。</p>
                        </div>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold shrink-0">3</span>
                        <div>
                            <p class="font-medium">プロフィールを充実させる</p>
                            <p class="text-sm text-gray-500">自己紹介・活動エリア・機材・ポートフォリオURLなどを入力しておくと、相手に信頼感を与えられます。</p>
                        </div>
                    </li>
                </ol>
                <div class="mt-6">
                    <a href="{{ route('register') }}"
                        class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700">
                        無料で登録する
                    </a>
                </div>
            </div>
        </section>

        {{-- 登録済みユーザー向け --}}
        <section class="mb-12">
            <h2 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">
                <span class="text-gray-400 text-base font-normal block mb-1">登録後にできること</span>
                募集を探す・投稿する
            </h2>

            <div class="grid sm:grid-cols-2 gap-4 mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="text-2xl mb-2">🔍</div>
                    <p class="font-medium mb-1">募集を探してメッセージ</p>
                    <p class="text-sm text-gray-500">気になる募集にメッセージを送り、撮影の詳細を相談できます。</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="text-2xl mb-2">📝</div>
                    <p class="font-medium mb-1">募集を投稿する</p>
                    <p class="text-sm text-gray-500">エリア・日程・報酬などの条件を書いて募集を出せます。</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="text-2xl mb-2">♥</div>
                    <p class="font-medium mb-1">ブックマーク</p>
                    <p class="text-sm text-gray-500">気になる募集をブックマークして後から見返せます。</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="text-2xl mb-2">🔄</div>
                    <p class="font-medium mb-1">モード切替</p>
                    <p class="text-sm text-gray-500">カメラマン・モデル両方のロールを持っていれば、ナビゲーションからモードを切り替えられます。</p>
                </div>
            </div>

            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
                <h3 class="font-bold mb-3">💬 メッセージを送れる条件</h3>
                <p class="text-sm text-gray-700 mb-3">すべての募集にメッセージを送れるわけではありません。以下の条件をすべて満たす必要があります。</p>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2"><span class="text-indigo-500">✓</span> 募集投稿者本人ではない</li>
                    <li class="flex gap-2"><span class="text-indigo-500">✓</span> 自分のモードが募集の対象ロールと一致している（例：カメラマンモードでモデル募集に応募）</li>
                    <li class="flex gap-2"><span class="text-indigo-500">✓</span> 募集に指定された性別・年齢の条件を満たしている</li>
                    <li class="flex gap-2"><span class="text-indigo-500">✓</span> 投稿者との間にブロック関係がない</li>
                    <li class="flex gap-2"><span class="text-indigo-500">✓</span> 募集が公開中である</li>
                </ul>
            </div>
        </section>

        {{-- FAQ --}}
        <section class="mb-12">
            <h2 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">よくある質問</h2>
            <div class="space-y-4">
                @foreach([
                    ['q' => 'カメラマンとモデル、両方に登録できますか？', 'a' => 'はい、できます。ロール設定でどちらも選択し、ナビのモード切替から使い分けられます。'],
                    ['q' => '無料で使えますか？', 'a' => 'はい、現在すべての機能を無料でご利用いただけます。'],
                    ['q' => '不審なユーザーがいた場合は？', 'a' => 'ユーザープロフィールや募集詳細ページから通報できます。また、ブロック機能でそのユーザーからのアクセスを遮断できます。'],
                    ['q' => '投稿した募集を編集・削除できますか？', 'a' => 'マイページ → 自分の募集 から編集・削除できます。'],
                ] as $faq)
                    <details class="bg-white border border-gray-200 rounded-xl overflow-hidden group">
                        <summary class="px-5 py-4 font-medium cursor-pointer list-none flex items-center justify-between hover:bg-gray-50">
                            {{ $faq['q'] }}
                            <span class="text-gray-400 text-lg">＋</span>
                        </summary>
                        <p class="px-5 pb-4 text-sm text-gray-600 border-t border-gray-100 pt-3">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>

        <div class="text-center py-8">
            <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:underline">← トップページに戻る</a>
        </div>
    </div>
</x-layouts.app>
