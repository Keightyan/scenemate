<x-layouts.guest>
    <x-slot:title>ログイン - SceneMate</x-slot:title>

    <h2 class="text-xl font-bold mb-6 text-center">ログイン</h2>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                    @error('email') border-red-400 @enderror">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">パスワード</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded"> ログインを保持
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">パスワードを忘れた</a>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm">
            ログイン
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-500">
        アカウントをお持ちでない方は
        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">新規登録</a>
    </p>
</x-layouts.guest>
