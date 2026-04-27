<x-layouts.app>
    <x-slot:title>{{ $user->username ?? $user->email }} - SceneMate</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="text-sm text-indigo-600 hover:underline">← 戻る</a>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl">👤</span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">{{ $user->username ?? $user->email }}</h1>
                        @if($user->prefecture)
                            <p class="text-sm text-gray-400">{{ $user->prefecture }}</p>
                        @endif
                        <div class="flex gap-1 mt-1">
                            @foreach($user->roles as $role)
                                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                @auth
                    @if(auth()->id() !== $user->id)
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('blocks.store') }}">
                                @csrf
                                <input type="hidden" name="blocked_user_id" value="{{ $user->id }}">
                                <button type="submit" onclick="return confirm('このユーザーをブロックしますか？')"
                                    class="text-xs border border-gray-300 px-3 py-1.5 rounded-lg hover:bg-gray-50">
                                    ブロック
                                </button>
                            </form>
                            <form method="POST" action="{{ route('reports.store') }}">
                                @csrf
                                <input type="hidden" name="reported_user_id" value="{{ $user->id }}">
                                <input type="hidden" name="reason" value="不適切なユーザー">
                                <button type="submit" onclick="return confirm('このユーザーを通報しますか？')"
                                    class="text-xs text-red-500 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50">
                                    通報
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            @if($user->bio)
                <p class="text-sm text-gray-700 mt-4 whitespace-pre-wrap">{{ $user->bio }}</p>
            @endif
        </div>

        @if($user->cameramanProfile)
            <div class="bg-white border border-gray-200 rounded-xl p-6 mb-4">
                <h2 class="font-semibold mb-3">カメラマン情報</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <dt class="text-xs text-gray-400">経験レベル</dt>
                        <dd>{{ ['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'][$user->cameramanProfile->experience_level] ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">撮影種別</dt>
                        <dd>{{ collect(['写真' => $user->cameramanProfile->can_shoot_photo, '動画' => $user->cameramanProfile->can_shoot_video])->filter()->keys()->join('、') ?: '-' }}</dd>
                    </div>
                    @if($user->cameramanProfile->genres)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">得意ジャンル</dt>
                            <dd>{{ $user->cameramanProfile->genres }}</dd>
                        </div>
                    @endif
                    @if($user->cameramanProfile->equipment)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">機材</dt>
                            <dd class="whitespace-pre-wrap">{{ $user->cameramanProfile->equipment }}</dd>
                        </div>
                    @endif
                    @if($user->cameramanProfile->portfolio_url)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">ポートフォリオ</dt>
                            <dd><a href="{{ $user->cameramanProfile->portfolio_url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline break-all">{{ $user->cameramanProfile->portfolio_url }}</a></dd>
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

        @if($user->modelProfile)
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="font-semibold mb-3">モデル情報</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    @if($user->modelProfile->height_cm)
                        <div>
                            <dt class="text-xs text-gray-400">身長</dt>
                            <dd>{{ $user->modelProfile->height_cm }}cm</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-gray-400">経験レベル</dt>
                        <dd>{{ ['beginner'=>'初心者','intermediate'=>'中級','pro'=>'プロ'][$user->modelProfile->experience_level] ?? '-' }}</dd>
                    </div>
                    @if($user->modelProfile->style_tags)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">得意スタイル</dt>
                            <dd>{{ $user->modelProfile->style_tags }}</dd>
                        </div>
                    @endif
                    @if($user->modelProfile->available_note)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">活動エリア・時間帯</dt>
                            <dd>{{ $user->modelProfile->available_note }}</dd>
                        </div>
                    @endif
                    @if($user->modelProfile->portfolio_url)
                        <div class="col-span-2">
                            <dt class="text-xs text-gray-400">ポートフォリオ</dt>
                            <dd><a href="{{ $user->modelProfile->portfolio_url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline break-all">{{ $user->modelProfile->portfolio_url }}</a></dd>
                        </div>
                    @endif
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
    </div>
</x-layouts.app>
