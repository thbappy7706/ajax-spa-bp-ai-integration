<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usersCount = \App\Models\User::count();
        $postsCount = \App\Models\Post::count();
        $categoriesCount = \App\Models\Category::count();
        $commentsCount = \App\Models\Comment::count();

        $recentPosts = \App\Models\Post::with('category')->latest()->take(5)->get();
        $recentComments = \App\Models\Comment::with(['post', 'user'])->latest()->take(5)->get();

        if ($request->ajax()) {
            return view('pages.dashboard', compact('usersCount', 'postsCount', 'categoriesCount', 'commentsCount', 'recentPosts', 'recentComments'))->renderSections()['content'];
        }

        return view('pages.dashboard', compact('usersCount', 'postsCount', 'categoriesCount', 'commentsCount', 'recentPosts', 'recentComments'));
    }

    public function stats(Request $request)
    {
        // For polling, return randomized fluctuations or real counts if they change
        return response()->json([
            'users' => \App\Models\User::count(),
            'posts' => \App\Models\Post::count(),
            'categories' => \App\Models\Category::count(),
            'comments' => \App\Models\Comment::count(),
            // Chart data
            'barData' => [
                rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100), rand(10, 100)
            ],
            'pieData' => [
                \App\Models\Post::where('status', 'published')->count(),
                \App\Models\Post::where('status', 'draft')->count(),
                \App\Models\Post::where('status', 'archived')->count(),
            ]
        ]);
    }
}
