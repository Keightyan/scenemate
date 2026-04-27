<x-layouts.guest>
    <x-slot:title>新規登録 - SceneMate</x-slot:title>

    <h2 class="text-xl font-bold mb-6 text-center">新規登録</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
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

        <div>
            <label class="block text-sm font-medium mb-1">パスワード（確認）</label>
            <input type="password" name="password_confirmation" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm">
            登録する
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-500">
        すでにアカウントをお持ちの方は
        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">ログイン</a>
    </p>
</x-layouts.guest>
