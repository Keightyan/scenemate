# SceneMate

<img width="1586" height="1058" alt="image" src="https://github.com/user-attachments/assets/1e0b1b2b-2c3a-4990-b902-7dc534447892" />

<br>

カメラマンとモデルをつなぐマッチングサービス。  
撮影パートナーを探して、理想の写真を一緒に作ろう。

---

## 概要

SceneMateは、カメラマンとモデルが互いに募集投稿を行い、メッセージを通じてマッチングするWebサービスです。  
個人開発によるポートフォリオ作品として、実務を想定した設計・実装を行いました。

---

## 機能一覧

### 認証
- メールアドレスによるユーザー登録・ログイン
- パスワードリセット（メール送信）

### ロール・モード
- カメラマン / モデルのロールを選択（両方選択可）
- 両ロール所持者はモードを切り替えて利用可能
- モードに応じた投稿一覧・ナビゲーションの出し分け

### 募集投稿
- モデル募集 / カメラマン募集の投稿作成・編集・削除
- 都道府県・市区町村・対象性別・対象年齢・報酬などの詳細条件設定
- 投稿の公開・停止切り替え
- モードによる閲覧制限（自分のロールに合った募集のみ表示）

### プロフィール
- アバター画像アップロード
- カメラマン情報（経験レベル・機材・ジャンル・Instagramアカウントなど）
- モデル情報（身長・スタイル・活動エリアなど）
- 作品・写真のアップロード（各最大6枚・40MBまで）
- 性別・生年月日は設定後に変更不可

### メッセージ
- 募集投稿ページからワンクリックでスレッド作成
- スレッドごとのメッセージ履歴表示
- 未読メッセージのバッジ表示（ヘッダー）
- 新着メッセージのメール通知

### その他
- 募集投稿のブックマーク（いいね）
- ユーザーのブロック
- ユーザー・投稿の通報（運営へメール通知）
- 都道府県での絞り込み検索

---

## 技術スタック

| 区分 | 技術 |
|---|---|
| バックエンド | PHP 8.2 / Laravel 12 |
| フロントエンド | Blade / TailwindCSS v4 / Vite |
| データベース | MySQL 8 |
| 開発環境 | Docker / Laravel Sail |
| バージョン管理 | Git / GitHub |

---

## 画面構成

```
/                   トップページ（最新募集・ヒーローセクション）
/posts              募集一覧（モデル募集 / カメラマン募集）
/posts/{id}         募集詳細
/posts/create       募集投稿
/users/{id}         ユーザープロフィール
/me                 マイページ
/me/edit            プロフィール編集
/messages           メッセージ一覧
/messages/{id}      メッセージスレッド
/guide              使い方ガイド
```

---

## DB設計（主要テーブル）

```
users               ユーザー情報（性別・生年月日・モードなど）
roles               ロール定義（cameraman / model）
role_user           ユーザーとロールの中間テーブル
cameraman_profiles  カメラマンプロフィール
model_profiles      モデルプロフィール
profile_photos      プロフィール写真（作品・モデル写真）
posts               募集投稿
likes               ブックマーク
threads             メッセージスレッド
messages            メッセージ
user_blocks         ブロック
reports             通報
```

---

## ローカル環境での起動手順

```bash
# リポジトリをクローン
git clone https://github.com/Keightyan/scenemate.git
cd scenemate

# 環境変数を設定
cp .env.example .env

# Composerパッケージをインストール
docker run --rm -v $(pwd):/app composer install

# コンテナ起動
./vendor/bin/sail up -d

# アプリケーションキーを生成
./vendor/bin/sail artisan key:generate

# マイグレーション実行
./vendor/bin/sail artisan migrate

# ストレージリンク作成
./vendor/bin/sail artisan storage:link

# フロントエンドビルド
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

起動後、http://localhost でアクセスできます。

---

## 工夫した点

- **HTML5 `form` 属性**を使ったネストできないフォームの解決（プロフィール編集ページ）
- **モードによる表示制御**：ロールに応じて閲覧できる投稿・ナビゲーションを動的に切り替え
- **自己防御の実装**：自分の投稿へのいいね防止・自分自身の通報禁止など
- **レスポンシブ対応**：モバイルファーストのハンバーガーメニュー・グリッドレイアウト
- **未読バッジ**：DBクエリで未読スレッドを判定し、ヘッダーにリアルタイム表示

---

## 作者

- GitHub: [@Keightyan](https://github.com/Keightyan)
