<x-layouts.app>
    <x-slot:title>ロール設定 - SceneMate</x-slot:title>

    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-2">ロール設定</h1>
        <p class="text-sm text-gray-500 mb-6">カメラマン・モデルのどちらとして活動するか選択してください。両方の選択も可能です。</p>

        <form method="POST" action="{{ route('settings.roles.update') }}" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf @method('PATCH')

            <div class="space-y-3 mb-6">
                <label class="flex items-start gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="checkbox" name="roles[]" value="photographer"
                        {{ in_array('photographer', old('roles', auth()->user()->roles->pluck('key')->toArray())) ? 'checked' : '' }}
                        class="mt-0.5">
                    <div>
                        <p class="font-medium">カメラマン</p>
                        <p class="text-sm text-gray-500">モデルの募集を作成したり、モデルを探せます。</p>
                    </div>
                </label>

                <label class="flex items-start gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="checkbox" name="roles[]" value="model"
                        {{ in_array('model', old('roles', auth()->user()->roles->pluck('key')->toArray())) ? 'checked' : '' }}
                        class="mt-0.5">
                    <div>
                        <p class="font-medium">モデル</p>
                        <p class="text-sm text-gray-500">カメラマンの募集に応募したり、カメラマンを探せます。</p>
                    </div>
                </label>
            </div>

            @error('roles') <p class="text-red-500 text-xs mb-4">{{ $message }}</p> @enderror

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium">
                保存する
            </button>
        </form>
    </div>
</x-layouts.app>
