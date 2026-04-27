<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $defaultTarget = $user?->current_mode ?? 'model';
        $posts = Post::with('owner')->open()->forRole($defaultTarget)->latest()->take(12)->get();

        return view('home', compact('posts'));
    }
}
