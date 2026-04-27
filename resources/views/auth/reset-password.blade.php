<x-layouts.guest>
    <x-slot:title>新しいパスワードの設定 - SceneMate</x-slot:title>

    <h2 class="text-xl font-bold mb-6 text-center">新しいパスワードを設定</h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-sm font-medium mb-1">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                    @error('email') border-red-400 @enderror">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">新しいパスワード</label>
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
            パスワードを変更
        </button>
    </form>
</x-layouts.guest>
