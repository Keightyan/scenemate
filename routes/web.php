<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// トップ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/guide', fn() => view('guide'))->name('guide');

// 認証（ゲスト限定）
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// 募集一覧（未ログインでも閲覧可）
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// 募集作成フォーム（要認証 - {post} より先に登録する必要あり）
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');

// 募集詳細（未ログインでも閲覧可）
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// プロフィール閲覧（未ログインでも閲覧可）
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');

// 認証必須
Route::middleware('auth')->group(function () {
    // マイページ・プロフィール
    Route::get('/me', [ProfileController::class, 'me'])->name('profile.me');
    Route::get('/me/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/me', [ProfileController::class, 'update'])->name('profile.update');

    // ロール・モード設定
    Route::get('/settings/roles', fn() => view('settings.roles'))->name('settings.roles.edit');
    Route::patch('/settings/roles', [SettingsController::class, 'updateRoles'])->name('settings.roles.update');
    Route::post('/mode/switch', [ModeController::class, 'switch'])->name('mode.switch');

    // 募集投稿・管理
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/me/posts', [PostController::class, 'mine'])->name('posts.mine');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // メッセージ
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{thread}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/posts/{post}/thread', [MessageController::class, 'startThread'])->name('messages.startThread');
    Route::post('/messages/{thread}', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/{thread}/read', [MessageController::class, 'markReadRoute'])->name('messages.read');

    // いいね（ブックマーク）
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('likes.destroy');
    Route::get('/me/likes/sent', [LikeController::class, 'sent'])->name('likes.sent');
    Route::get('/me/likes/received', [LikeController::class, 'received'])->name('likes.received');

    // プロフィール写真
    Route::post('/profile/photos', [ProfilePhotoController::class, 'store'])->name('profile.photos.store');
    Route::delete('/profile/photos/{photo}', [ProfilePhotoController::class, 'destroy'])->name('profile.photos.destroy');

    // ブロック
    Route::post('/blocks', [BlockController::class, 'store'])->name('blocks.store');
    Route::delete('/blocks/{user}', [BlockController::class, 'destroy'])->name('blocks.destroy');

    // 通報
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});
