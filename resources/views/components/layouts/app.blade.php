<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SceneMate' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">

<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-14">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-indigo-600">SceneMate</a>

        {{-- デスクトップナビ --}}
        <div class="hidden md:flex items-center gap-4 text-sm">
            @php $navMode = auth()->user()?->current_mode; @endphp
            @if(!$navMode || $navMode === 'model')
                <a href="{{ route('posts.index', ['target' => 'model']) }}" class="hover:text-indigo-600">モデル募集</a>
            @endif
            @if(!$navMode || $navMode === 'photographer')
                <a href="{{ route('posts.index', ['target' => 'photographer']) }}" class="hover:text-indigo-600">カメラマン募集</a>
            @endif
            <a href="{{ route('guide') }}" class="hover:text-indigo-600">使い方</a>

            @auth
                @php $authUser = auth()->user()->loadMissing('roles'); @endphp
                @php $hasUnread = $authUser->hasUnreadMessages(); @endphp
                <a href="{{ route('messages.index') }}" class="relative hover:text-indigo-600">
                    メッセージ
                    @if($hasUnread)
                        <span class="absolute -top-1 -right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </a>


                @if($authUser->roles->count() > 1 && $authUser->current_mode)
                    <form action="{{ route('mode.switch') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="mode"
                            value="{{ $authUser->current_mode === 'photographer' ? 'model' : 'photographer' }}">
                        <button type="submit"
                            class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-200">
                            {{ $authUser->current_mode === 'photographer' ? 'カメラマンモード' : 'モデルモード' }} ▼切替
                        </button>
                    </form>
                @endif

                <div class="relative" id="user-menu-wrap">
                    <button type="button" id="user-menu-btn"
                        class="flex items-center gap-1.5 hover:opacity-75 transition">
                        <div class="w-7 h-7 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center shrink-0">
                            @if(auth()->user()->avatar_path)
                                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" class="w-full h-full object-cover" alt="avatar">
                            @else
                                <span class="text-xs leading-none">👤</span>
                            @endif
                        </div>
                        <span class="text-sm max-w-28 truncate">{{ auth()->user()->username ?? auth()->user()->email }}</span>
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3.5L5 6.5L8 3.5"/></svg>
                    </button>
                    <div id="user-menu-dropdown"
                        class="hidden absolute right-0 top-full mt-1.5 w-48 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-50">
                        <a href="{{ route('profile.me') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">マイページ</a>
                        <a href="{{ route('users.show', auth()->user()) }}" class="block px-4 py-2 text-sm hover:bg-gray-50">プロフィールを見る</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">プロフィール編集</a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">ログアウト</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-indigo-600">ログイン</a>
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700">新規登録</a>
            @endauth
        </div>

        {{-- モバイル右側 --}}
        <div class="flex md:hidden items-center gap-3">
            @auth
                <a href="{{ route('messages.index') }}" class="relative text-sm hover:text-indigo-600">
                    メッセージ
                    @if(auth()->user()->hasUnreadMessages())
                        <span class="absolute -top-1 -right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </a>
                <div class="relative" id="user-menu-wrap-mobile">
                    <button type="button" id="user-menu-btn-mobile"
                        class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center shrink-0">
                        @if(auth()->user()->avatar_path)
                            <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" class="w-full h-full object-cover" alt="avatar">
                        @else
                            <span class="text-xs leading-none">👤</span>
                        @endif
                    </button>
                    <div id="user-menu-dropdown-mobile"
                        class="hidden absolute right-0 top-full mt-1.5 w-48 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-50">
                        <a href="{{ route('profile.me') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">マイページ</a>
                        <a href="{{ route('users.show', auth()->user()) }}" class="block px-4 py-2 text-sm hover:bg-gray-50">プロフィールを見る</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">プロフィール編集</a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">ログアウト</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:text-indigo-600">ログイン</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md text-sm hover:bg-indigo-700">新規登録</a>
            @endauth

            {{-- ハンバーガー --}}
            <button id="mobile-menu-btn" type="button" class="p-1.5 rounded hover:bg-gray-100">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- モバイルメニュー --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1 text-sm">
            @php $navMode = auth()->user()?->current_mode; @endphp
            @if(!$navMode || $navMode === 'model')
                <a href="{{ route('posts.index', ['target' => 'model']) }}" class="block py-2 hover:text-indigo-600">モデル募集</a>
            @endif
            @if(!$navMode || $navMode === 'photographer')
                <a href="{{ route('posts.index', ['target' => 'photographer']) }}" class="block py-2 hover:text-indigo-600">カメラマン募集</a>
            @endif
            <a href="{{ route('guide') }}" class="block py-2 hover:text-indigo-600">使い方</a>
            @auth
                @php $authUserMobile = auth()->user()->loadMissing('roles'); @endphp
                @if($authUserMobile->roles->count() > 1 && $authUserMobile->current_mode)
                    <div class="py-2">
                        <form action="{{ route('mode.switch') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="mode"
                                value="{{ $authUserMobile->current_mode === 'photographer' ? 'model' : 'photographer' }}">
                            <button type="submit"
                                class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded hover:bg-indigo-200">
                                {{ $authUserMobile->current_mode === 'photographer' ? 'カメラマンモード' : 'モデルモード' }} ▼切替
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-4 py-6">
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-md text-sm">
            {{ session('info') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-md text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot }}
</main>

<footer class="mt-16 border-t border-gray-200 py-6 text-center text-xs text-gray-400">
    &copy; {{ date('Y') }} SceneMate
</footer>

<script>
(function () {
    // デスクトップ ユーザーメニュー
    var btn = document.getElementById('user-menu-btn');
    var dd  = document.getElementById('user-menu-dropdown');
    if (btn && dd) {
        btn.addEventListener('click', function (e) { e.stopPropagation(); dd.classList.toggle('hidden'); });
    }

    // モバイル ユーザーメニュー
    var btnM = document.getElementById('user-menu-btn-mobile');
    var ddM  = document.getElementById('user-menu-dropdown-mobile');
    if (btnM && ddM) {
        btnM.addEventListener('click', function (e) { e.stopPropagation(); ddM.classList.toggle('hidden'); });
    }

    // ハンバーガーメニュー
    var hamburger = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function (e) { e.stopPropagation(); mobileMenu.classList.toggle('hidden'); });
    }

    document.addEventListener('click', function () {
        if (dd)  dd.classList.add('hidden');
        if (ddM) ddM.classList.add('hidden');
        if (mobileMenu) mobileMenu.classList.add('hidden');
    });
})();
</script>
</body>
</html>
