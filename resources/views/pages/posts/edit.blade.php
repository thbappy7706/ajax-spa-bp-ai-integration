@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')
<style>
    .form-floating { position: relative; margin-bottom: 1rem; }
    .form-floating > .inp { height: calc(3.5rem + 2px); padding: 1rem 0.75rem; }
    .form-floating > label {
        position: absolute; top: 0; left: 0; height: 100%; padding: 1rem 0.75rem;
        pointer-events: none; border: 1px solid transparent; transform-origin: 0 0;
        transition: opacity .1s ease-in-out,transform .1s ease-in-out;
        color: var(--muted-foreground);
    }
    .form-floating > .inp:focus, .form-floating > .inp:not(:placeholder-shown) {
        padding-top: 1.625rem; padding-bottom: 0.625rem;
    }
    .form-floating > .inp:focus ~ label, .form-floating > .inp:not(:placeholder-shown) ~ label {
        opacity: .65; transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }
    select.inp { appearance: none; }
</style>

<div class="topbar fi">
    <div>
        <h1 class="ptitle">Edit Post</h1>
        <div class="psub">Update existing blog post.</div>
    </div>
    <button class="btn" onclick="navigateTo('/posts')">Back to Posts</button>
</div>

<div class="card fi" style="max-width: 900px; margin: 0 auto; padding: 30px;">
    <form id="postForm" onsubmit="updatePost(event)">
        <div class="form-floating">
            <input type="text" class="inp" id="title" name="title" placeholder="Title" value="{{ $post->title }}" required>
            <label for="title">Post Title</label>
        </div>

        <div class="frow">
            <div class="form-floating">
                <select class="inp" id="category_id" name="category_id" required>
                    <option value="" disabled>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="category_id">Category</label>
            </div>
            <div class="form-floating">
                <select class="inp" id="status" name="status" required>
                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ $post->status == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <label for="status">Status</label>
            </div>
        </div>

        <div class="form-floating" style="margin-top: 10px;">
            <textarea class="inp" id="content" name="content" placeholder="Content" style="height: 200px;" required>{{ $post->content }}</textarea>
            <label for="content">Post Content</label>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn p">Update Post</button>
        </div>
    </form>
</div>

<script>
    function updatePost(e) {
        e.preventDefault();
        const data = {
            title: $('#title').val(),
            category_id: $('#category_id').val(),
            status: $('#status').val(),
            content: $('#content').val(),
            _method: 'PUT'
        };

        $.ajax({
            url: '/posts/{{ $post->id }}',
            type: 'POST',
            data: data,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                toast('Post updated successfully!');
                navigateTo('/posts');
            },
            error: function(err) {
                toast('Error updating post', 'error');
            }
        });
    }
</script>
@endsection
