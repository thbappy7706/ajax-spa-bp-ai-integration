<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() && $request->has('draw')) {
            $query = Comment::with(['post', 'user'])->select('comments.*');

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($comment) {
                    return '
                        <a href="javascript:void(0)" onclick="editComment('.$comment->id.')" class="btn p" style="padding: 4px 8px; font-size: 0.7rem;">Edit</a>
                        <button onclick="deleteComment('.$comment->id.')" class="btn d" style="padding: 4px 8px; font-size: 0.7rem;">Delete</button>
                    ';
                })
                ->editColumn('status', function ($comment) {
                    $class = $comment->status === 'approved' ? 'bu' : ($comment->status === 'pending' ? 'bg' : 'bd');
                    return '<span class="bdg '.$class.'">'.ucfirst($comment->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        if ($request->ajax()) {
            return view('pages.comments.index')->renderSections()['content'];
        }
        return view('pages.comments.index');
    }

    public function create(Request $request)
    {
        $posts = Post::all();
        if ($request->wantsJson()) {
            return response()->json(['posts' => $posts]);
        }
        if ($request->ajax()) {
            return view('pages.comments.create', compact('posts'))->renderSections()['content'];
        }
        return view('pages.comments.create', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
            'status' => 'required|in:pending,approved,spam,trashed',
        ]);

        $validated['user_id'] = auth()->id() ?? 1;

        Comment::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit(Request $request, Comment $comment)
    {
        $posts = Post::all();
        if ($request->wantsJson()) {
            return response()->json(['comment' => $comment, 'posts' => $posts]);
        }
        if ($request->ajax()) {
            return view('pages.comments.edit', compact('comment', 'posts'))->renderSections()['content'];
        }
        return view('pages.comments.edit', compact('comment', 'posts'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
            'status' => 'required|in:pending,approved,spam,trashed',
        ]);

        $comment->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['success' => true]);
    }
}
