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

        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('posts.index', ['target' => 'model']) }}" class="hover:text-indigo-600">モデル募集</a>
            <a href="{{ route('posts.index', ['target' => 'photographer']) }}" class="hover:text-indigo-600">カメラマン募集</a>

            @auth
                <a href="{{ route('messages.index') }}" class="hover:text-indigo-600">メッセージ</a>

                {{-- モード切替 --}}
                @if(auth()->user()->current_mode)
                    <form action="{{ route('mode.switch') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="mode"
                            value="{{ auth()->user()->current_mode === 'photographer' ? 'model' : 'photographer' }}">
                        <button type="submit"
                            class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded hover:bg-indigo-200">
                            {{ auth()->user()->current_mode === 'photographer' ? 'カメラマンモード' : 'モデルモード' }} ▼切替
                        </button>
                    </form>
                @endif

                <a href="{{ route('profile.me') }}" class="hover:text-indigo-600">マイページ</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-red-500">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-indigo-600">ログイン</a>
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700">新規登録</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-4 py-8">
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

</body>
</html>
