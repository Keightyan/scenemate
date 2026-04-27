<x-layouts.app>
    <x-slot:title>募集を投稿 - SceneMate</x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">募集を投稿</h1>
        @if($hasBothRoles)
            <p class="text-sm text-gray-500 mb-6">現在のモード: <span class="font-medium">{{ $mode === 'photographer' ? 'カメラマン' : 'モデル' }}</span></p>
        @endif

        <form method="POST" action="{{ route('posts.store') }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
            @csrf

            {{-- 募集対象 --}}
            @if($hasBothRoles)
                <div>
                    <label class="block text-sm font-medium mb-1">募集対象 <span class="text-red-500">*</span></label>
                    <select name="target_role"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="model"       {{ (old('target_role', $defaultTarget) === 'model')       ? 'selected' : '' }}>モデル</option>
                        <option value="photographer" {{ (old('target_role', $defaultTarget) === 'photographer') ? 'selected' : '' }}>カメラマン</option>
                    </select>
                </div>
            @else
                <input type="hidden" name="target_role" value="{{ $defaultTarget }}">
            @endif

            <div>
                <label class="block text-sm font-medium mb-1">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="150"
                    placeholder="例: 自然光ポートレート撮影のモデル募集"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                        @error('title') border-red-400 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">詳細</label>
                <textarea name="description" rows="5" maxlength="5000"
                    placeholder="撮影内容、条件、ご要望などをご記入ください"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">対象性別</label>
                    <select name="target_gender"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="any"    {{ old('target_gender') === 'any'    ? 'selected' : '' }}>不問</option>
                        <option value="female" {{ old('target_gender') === 'female' ? 'selected' : '' }}>女性</option>
                        <option value="male"   {{ old('target_gender') === 'male'   ? 'selected' : '' }}>男性</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">対象年齢</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="target_age_min" value="{{ old('target_age_min') }}" min="0" max="120"
                            placeholder="下限"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span class="text-gray-400">〜</span>
                        <input type="number" name="target_age_max" value="{{ old('target_age_max') }}" min="0" max="120"
                            placeholder="上限"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <x-prefecture-city-select
                :prefectureValue="old('location_prefecture', '')"
                :cityValue="old('location_detail', '')"
                prefectureName="location_prefecture"
                cityName="location_detail"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">日程の目安</label>
                    <input type="text" name="date_note" value="{{ old('date_note') }}" maxlength="255"
                        placeholder="例: 平日午後 / 土日"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">報酬・交通費</label>
                    <input type="text" name="reward_note" value="{{ old('reward_note') }}" maxlength="255"
                        placeholder="例: 交通費支給 / データ提供"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700 font-medium">
                    投稿する
                </button>
                <a href="{{ route('posts.index', ['target' => $mode === 'photographer' ? 'model' : 'photographer']) }}"
                    class="px-6 py-2 rounded-lg text-sm border border-gray-300 hover:bg-gray-50">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
