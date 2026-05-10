<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() && $request->has('draw')) {
            $query = Post::with(['category', 'user'])->select('posts.*');

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($post) {
                    return '
                        <a href="javascript:void(0)" onclick="editPost('.$post->id.')" class="btn p" style="padding: 4px 8px; font-size: 0.7rem;">Edit</a>
                        <button onclick="deletePost('.$post->id.')" class="btn d" style="padding: 4px 8px; font-size: 0.7rem;">Delete</button>
                    ';
                })
                ->editColumn('status', function ($post) {
                    $class = $post->status === 'published' ? 'bu' : ($post->status === 'draft' ? 'bg' : 'bd');
                    return '<span class="bdg '.$class.'">'.ucfirst($post->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        if ($request->ajax()) {
            return view('pages.posts.index')->renderSections()['content'];
        }
        return view('pages.posts.index');
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        if ($request->wantsJson()) {
            return response()->json(['categories' => $categories]);
        }
        if ($request->ajax()) {
            return view('pages.posts.create', compact('categories'))->renderSections()['content'];
        }
        return view('pages.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['user_id'] = auth()->id() ?? 1;

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit(Request $request, Post $post)
    {
        $categories = Category::all();
        if ($request->wantsJson()) {
            return response()->json(['post' => $post, 'categories' => $categories]);
        }
        if ($request->ajax()) {
            return view('pages.posts.edit', compact('post', 'categories'))->renderSections()['content'];
        }
        return view('pages.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $post->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['success' => true]);
    }
}
