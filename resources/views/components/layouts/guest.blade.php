<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SceneMate' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex flex-col items-center justify-center">
    <a href="{{ route('home') }}" class="mb-8 text-2xl font-bold text-indigo-600">SceneMate</a>

    <div class="w-full max-w-sm bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        {{ $slot }}
    </div>
</body>
</html>
