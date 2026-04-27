<x-layouts.app>
    <x-slot:title>マイページ - SceneMate</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden shrink-0">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl">👤</span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">{{ $user->username ?? $user->email }}</h1>
                        @if($user->prefecture)
                            <p class="text-sm text-gray-400">{{ $user->prefecture }} {{ $user->city }}</p>
                        @endif
                        <div class="flex gap-1 mt-1">
                            @foreach($user->roles as $role)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                            @if($user->current_mode)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">
                                    現在: {{ $user->current_mode === 'photographer' ? 'カメラマン' : 'モデル' }}モード
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('users.show', $user) }}"
                        class="text-sm border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">
                        プロフィールを見る
                    </a>
                    <a href="{{ route('settings.roles.edit') }}"
                        class="text-sm border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">
                        ロール設定
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="text-sm border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50">
                        プロフィール編集
                    </a>
                </div>
            </div>

            @if($user->bio)
                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $user->bio }}</p>
            @endif
        </div>

        {{-- ナビゲーション --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            <a href="{{ route('posts.mine') }}"
                class="block bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:shadow-sm transition">
                <div class="text-2xl mb-1">📋</div>
                <p class="text-sm font-medium">自分の募集</p>
            </a>
            <a href="{{ route('messages.index') }}"
                class="block bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:shadow-sm transition">
                <div class="text-2xl mb-1">💬</div>
                <p class="text-sm font-medium">メッセージ</p>
            </a>
            <a href="{{ route('likes.sent') }}"
                class="block bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:shadow-sm transition">
                <div class="text-2xl mb-1">♥</div>
                <p class="text-sm font-medium">ブックマーク</p>
            </a>
            <a href="{{ route('likes.received') }}"
                class="block bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:shadow-sm transition">
                <div class="text-2xl mb-1">⭐</div>
                <p class="text-sm font-medium">もらったいいね</p>
            </a>
        </div>

        {{-- ロール未設定の案内 --}}
        @if($user->roles->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800 mb-6">
                まずロールを設定してください。
                <a href="{{ route('settings.roles.edit') }}" class="underline ml-1">ロール設定へ</a>
            </div>
        @endif

        @if($user->roles->isNotEmpty())
            {{-- カメラマンプロフィール --}}
            @if($user->cameramanProfile)
                <div class="bg-white border border-gray-200 rounded-xl p-6 mb-4">

                    <h2 class="font-semibold mb-3">カメラマンプロフィール</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-xs text-gray-400">経験レベル</dt>
                            <dd>{{ ['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'][$user->cameramanProfile->experience_level] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">撮影種別</dt>
                            <dd>{{ collect(['写真' => $user->cameramanProfile->can_shoot_photo, '動画' => $user->cameramanProfile->can_shoot_video])->filter()->keys()->join('、') ?: '-' }}</dd>
                        </div>
                        @if($user->cameramanProfile->equipment)
                            <div class="col-span-2">
                                <dt class="text-xs text-gray-400">機材</dt>
                                <dd class="whitespace-pre-wrap">{{ $user->cameramanProfile->equipment }}</dd>
                            </div>
                        @endif
                        @if($user->cameramanProfile->instagram_account)
                            <div class="col-span-2">
                                <dt class="text-xs text-gray-400">Instagram</dt>
                                <dd>
                                    <a href="https://instagram.com/{{ $user->cameramanProfile->instagram_account }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                        {{ '@'.$user->cameramanProfile->instagram_account }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
                @if($user->cameramanPhotos->isNotEmpty())
                    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-4">
                        <h2 class="font-semibold mb-3 text-sm">カメラマン写真</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach($user->cameramanPhotos as $photo)
                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full aspect-square object-cover rounded-lg">
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- モデルプロフィール --}}
            @if($user->modelProfile)
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h2 class="font-semibold mb-3">モデルプロフィール</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-xs text-gray-400">身長</dt>
                            <dd>{{ $user->modelProfile->height_cm ? $user->modelProfile->height_cm . 'cm' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">経験レベル</dt>
                            <dd>{{ ['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'][$user->modelProfile->experience_level] ?? '-' }}</dd>
                        </div>
                        @if($user->modelProfile->instagram_account)
                            <div class="col-span-2">
                                <dt class="text-xs text-gray-400">Instagram</dt>
                                <dd>
                                    <a href="https://instagram.com/{{ $user->modelProfile->instagram_account }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:underline">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                        {{ '@'.$user->modelProfile->instagram_account }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
                @if($user->modelPhotos->isNotEmpty())
                    <div class="bg-white border border-gray-200 rounded-xl p-6 mt-4">
                        <h2 class="font-semibold mb-3 text-sm">モデル写真</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach($user->modelPhotos as $photo)
                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full aspect-square object-cover rounded-lg">
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </div>
</x-layouts.app>
