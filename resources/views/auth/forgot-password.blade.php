<x-layouts.guest>
    <x-slot:title>パスワードリセット - SceneMate</x-slot:title>

    <h2 class="text-xl font-bold mb-4 text-center">パスワードリセット</h2>
    <p class="text-sm text-gray-500 mb-6 text-center">登録済みのメールアドレスにリセットリンクを送信します。</p>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                    @error('email') border-red-400 @enderror">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm">
            リセットリンクを送信
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">ログインに戻る</a>
    </p>
</x-layouts.guest>
