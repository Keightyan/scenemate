<x-layouts.app>
    <x-slot:title>プロフィール編集 - SceneMate</x-slot:title>

    {{-- メインフォーム（ID参照でどこからでも入力を紐付けられる） --}}
    <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PATCH')
    </form>

    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold">プロフィール編集</h1>

        {{-- 基本情報 --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
            <h2 class="font-semibold">基本情報</h2>

            <div>
                <label class="block text-sm font-medium mb-2">プロフィール画像</label>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden shrink-0">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="w-full h-full object-cover" id="avatar-preview">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl" id="avatar-placeholder">👤</div>
                            <img src="" alt="" class="w-full h-full object-cover hidden" id="avatar-preview">
                        @endif
                    </div>
                    <div>
                        <input type="file" name="avatar" accept="image/*" id="avatar-input" form="profile-form"
                            class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-gray-300 file:text-sm file:bg-white hover:file:bg-gray-50">
                        <p class="text-xs text-gray-400 mt-1">JPG・PNG・WebP、2MB以下</p>
                        @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">ユーザー名</label>
                <input type="text" name="username" form="profile-form" value="{{ old('username', $user->username) }}" maxlength="50"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('username') border-red-400 @enderror">
                @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">自己紹介</label>
                <textarea name="bio" form="profile-form" rows="4" maxlength="1000"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">性別</label>
                    @if($user->gender)
                        <p class="px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700">
                            {{ ['female' => '女性', 'male' => '男性'][$user->gender] ?? $user->gender }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">再設定はできません</p>
                    @else
                        <select name="gender" form="profile-form"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">選択しない</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>女性</option>
                            <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>男性</option>
                        </select>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">生年月日</label>
                    @if($user->birth_date)
                        <p class="px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700">
                            {{ $user->birth_date->format('Y年m月d日') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">再設定はできません</p>
                    @else
                        <input type="date" name="birth_date" form="profile-form"
                            value="{{ old('birth_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @endif
                </div>
            </div>

            <x-prefecture-city-select
                :prefectureValue="old('prefecture', $user->prefecture ?? '')"
                :cityValue="old('city', $user->city ?? '')"
                formId="profile-form"
            />
        </div>

        {{-- カメラマン情報 + 作品 --}}
        @if($user->isPhotographer())
            <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
                <h2 class="font-semibold">カメラマン情報</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">経験レベル</label>
                        <select name="experience_level_cam" form="profile-form"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">選択しない</option>
                            @foreach(['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'] as $val => $label)
                                <option value="{{ $val }}" {{ old('experience_level_cam', $user->cameramanProfile?->experience_level) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">撮影種別</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="can_shoot_photo" form="profile-form" value="1"
                                    {{ old('can_shoot_photo', $user->cameramanProfile?->can_shoot_photo) ? 'checked' : '' }}>
                                写真
                            </label>
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="can_shoot_video" form="profile-form" value="1"
                                    {{ old('can_shoot_video', $user->cameramanProfile?->can_shoot_video) ? 'checked' : '' }}>
                                動画
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">機材</label>
                    <textarea name="equipment" form="profile-form" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('equipment', $user->cameramanProfile?->equipment) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">得意ジャンル</label>
                    <input type="text" name="genres" form="profile-form"
                        value="{{ old('genres', $user->cameramanProfile?->genres) }}"
                        placeholder="例: ポートレート, 風景, 商品撮影"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">報酬の考え方</label>
                    <textarea name="price_note" form="profile-form" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('price_note', $user->cameramanProfile?->price_note) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">ポートフォリオURL</label>
                        <input type="url" name="portfolio_url_cam" form="profile-form"
                            value="{{ old('portfolio_url_cam', $user->cameramanProfile?->portfolio_url) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('portfolio_url_cam') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Instagramアカウント</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">@</span>
                            <input type="text" name="instagram_account_cam" form="profile-form"
                                value="{{ old('instagram_account_cam', $user->cameramanProfile?->instagram_account) }}"
                                placeholder="username"
                                class="w-full border border-gray-300 rounded-lg pl-7 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        @error('instagram_account_cam') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- 作品 --}}
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold">作品 <span class="text-xs text-gray-400 font-normal">（最大6枚・40MB以下）</span></h3>
                        <span class="text-xs text-gray-400">{{ $user->cameramanPhotos->count() }}/6</span>
                    </div>
                    @error('photo_cameraman') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror
                    @if($user->cameramanPhotos->isNotEmpty())
                        <div class="flex flex-wrap gap-3 mb-3">
                            @foreach($user->cameramanPhotos as $photo)
                                <div class="relative w-24 h-24">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full h-full object-cover rounded-lg">
                                    <form method="POST" action="{{ route('profile.photos.destroy', $photo) }}" class="absolute top-1 right-1">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600 leading-none">&times;</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($user->cameramanPhotos->count() < 6)
                        <form method="POST" action="{{ route('profile.photos.store') }}" enctype="multipart/form-data" id="cam-photo-form">
                            @csrf
                            <input type="hidden" name="type" value="cameraman">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-indigo-600 border border-indigo-300 px-4 py-2 rounded-lg hover:bg-indigo-50">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                写真を選択してアップロード
                                <input type="file" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('cam-photo-form').submit()">
                            </label>
                        </form>
                    @endif
                </div>
            </div>
        @endif

        {{-- モデル情報 + 写真 --}}
        @if($user->isModel())
            <div class="bg-white border border-gray-200 rounded-xl p-6 space-y-4">
                <h2 class="font-semibold">モデル情報</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">身長 (cm)</label>
                        <input type="number" name="height_cm" form="profile-form" min="100" max="250"
                            value="{{ old('height_cm', $user->modelProfile?->height_cm) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('height_cm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">経験レベル</label>
                        <select name="experience_level_mod" form="profile-form"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">選択しない</option>
                            @foreach(['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'] as $val => $label)
                                <option value="{{ $val }}" {{ old('experience_level_mod', $user->modelProfile?->experience_level) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">得意スタイル・雰囲気</label>
                    <input type="text" name="style_tags" form="profile-form"
                        value="{{ old('style_tags', $user->modelProfile?->style_tags) }}"
                        placeholder="例: ナチュラル, クール, 和装"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">活動可能エリア・時間帯</label>
                    <textarea name="available_note" form="profile-form" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('available_note', $user->modelProfile?->available_note) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">ポートフォリオURL</label>
                        <input type="url" name="portfolio_url_mod" form="profile-form"
                            value="{{ old('portfolio_url_mod', $user->modelProfile?->portfolio_url) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('portfolio_url_mod') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Instagramアカウント</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">@</span>
                            <input type="text" name="instagram_account_mod" form="profile-form"
                                value="{{ old('instagram_account_mod', $user->modelProfile?->instagram_account) }}"
                                placeholder="username"
                                class="w-full border border-gray-300 rounded-lg pl-7 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        @error('instagram_account_mod') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- 写真 --}}
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold">写真 <span class="text-xs text-gray-400 font-normal">（最大6枚・40MB以下）</span></h3>
                        <span class="text-xs text-gray-400">{{ $user->modelPhotos->count() }}/6</span>
                    </div>
                    @error('photo_model') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror
                    @if($user->modelPhotos->isNotEmpty())
                        <div class="flex flex-wrap gap-3 mb-3">
                            @foreach($user->modelPhotos as $photo)
                                <div class="relative w-24 h-24">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full h-full object-cover rounded-lg">
                                    <form method="POST" action="{{ route('profile.photos.destroy', $photo) }}" class="absolute top-1 right-1">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600 leading-none">&times;</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($user->modelPhotos->count() < 6)
                        <form method="POST" action="{{ route('profile.photos.store') }}" enctype="multipart/form-data" id="mod-photo-form">
                            @csrf
                            <input type="hidden" name="type" value="model">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-indigo-600 border border-indigo-300 px-4 py-2 rounded-lg hover:bg-indigo-50">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                写真を選択してアップロード
                                <input type="file" name="photo" accept="image/*" class="hidden" onchange="document.getElementById('mod-photo-form').submit()">
                            </label>
                        </form>
                    @endif
                </div>
            </div>
        @endif

        {{-- 保存ボタン --}}
        <div class="flex items-center justify-between">
            <div class="flex gap-3">
                <button type="submit" form="profile-form"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700 font-medium">
                    保存する
                </button>
                <a href="{{ route('users.show', $user) }}"
                    class="px-6 py-2 rounded-lg text-sm border border-gray-300 hover:bg-gray-50">
                    キャンセル
                </a>
            </div>
            <a href="{{ route('settings.roles.edit') }}" class="text-xs text-gray-400 hover:text-indigo-600 hover:underline">
                ロール設定 →
            </a>
        </div>
    </div>

    <script>
        document.getElementById('avatar-input')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        });
    </script>
</x-layouts.app>
