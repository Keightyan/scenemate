<x-layouts.app>
    <x-slot:title>募集を編集 - SceneMate</x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">募集を編集</h1>

        <form method="POST" action="{{ route('posts.update', $post) }}" class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
            @csrf @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-1">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required maxlength="150"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                        @error('title') border-red-400 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">詳細</label>
                <textarea name="description" rows="5"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">対象性別</label>
                    <select name="target_gender"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="any"    {{ old('target_gender', $post->target_gender) === 'any'    ? 'selected' : '' }}>不問</option>
                        <option value="female" {{ old('target_gender', $post->target_gender) === 'female' ? 'selected' : '' }}>女性</option>
                        <option value="male"   {{ old('target_gender', $post->target_gender) === 'male'   ? 'selected' : '' }}>男性</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">公開状態</label>
                    <select name="is_open"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="1" {{ old('is_open', $post->is_open ? '1' : '0') === '1' ? 'selected' : '' }}>公開中</option>
                        <option value="0" {{ old('is_open', $post->is_open ? '1' : '0') === '0' ? 'selected' : '' }}>停止</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">対象年齢</label>
                <div class="flex items-center gap-2">
                    <input type="number" name="target_age_min" value="{{ old('target_age_min', $post->target_age_min) }}" min="0" max="120"
                        placeholder="下限"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="text-gray-400">〜</span>
                    <input type="number" name="target_age_max" value="{{ old('target_age_max', $post->target_age_max) }}" min="0" max="120"
                        placeholder="上限"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <x-prefecture-city-select
                :prefectureValue="old('location_prefecture', $post->location_prefecture ?? '')"
                :cityValue="old('location_detail', $post->location_detail ?? '')"
                prefectureName="location_prefecture"
                cityName="location_detail"
            />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">日程の目安</label>
                    <input type="text" name="date_note" value="{{ old('date_note', $post->date_note) }}" maxlength="255"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">報酬・交通費</label>
                    <input type="text" name="reward_note" value="{{ old('reward_note', $post->reward_note) }}" maxlength="255"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700 font-medium">
                    更新する
                </button>
                <a href="{{ route('posts.show', $post) }}"
                    class="px-6 py-2 rounded-lg text-sm border border-gray-300 hover:bg-gray-50">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
