<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() && $request->has('draw')) {
            $query = Category::query();

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($category) {
                    return '
                        <a href="javascript:void(0)" onclick="editCategory('.$category->id.')" class="btn p" style="padding: 4px 8px; font-size: 0.7rem;">Edit</a>
                        <button onclick="deleteCategory('.$category->id.')" class="btn d" style="padding: 4px 8px; font-size: 0.7rem;">Delete</button>
                    ';
                })
                ->editColumn('status', function ($category) {
                    $class = $category->status === 'active' ? 'bu' : 'bd';
                    return '<span class="bdg '.$class.'">'.ucfirst($category->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        if ($request->ajax()) {
            return view('pages.categories.index')->renderSections()['content'];
        }
        return view('pages.categories.index');
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.categories.create')->renderSections()['content'];
        }
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        Category::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit(Request $request, Category $category)
    {
        if ($request->wantsJson()) {
            return response()->json(['category' => $category]);
        }
        if ($request->ajax()) {
            return view('pages.categories.edit', compact('category'))->renderSections()['content'];
        }
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }
}
