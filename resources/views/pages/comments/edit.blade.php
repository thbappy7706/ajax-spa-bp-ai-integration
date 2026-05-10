@extends('layouts.app')
@section('title', 'Edit Comment')
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
        <h1 class="ptitle">Edit Comment</h1>
        <div class="psub">Update an existing comment.</div>
    </div>
    <button class="btn" onclick="navigateTo('/comments')">Back to Comments</button>
</div>

<div class="card fi" style="max-width: 900px; margin: 0 auto; padding: 30px;">
    <form id="commentForm" onsubmit="updateComment(event)">
        <div class="frow">
            <div class="form-floating">
                <select class="inp" id="post_id" name="post_id" required>
                    <option value="" disabled>Select Post</option>
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}" {{ $comment->post_id == $post->id ? 'selected' : '' }}>{{ $post->title }}</option>
                    @endforeach
                </select>
                <label for="post_id">Post</label>
            </div>
            <div class="form-floating">
                <select class="inp" id="status" name="status" required>
                    <option value="pending" {{ $comment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $comment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="spam" {{ $comment->status == 'spam' ? 'selected' : '' }}>Spam</option>
                    <option value="trashed" {{ $comment->status == 'trashed' ? 'selected' : '' }}>Trashed</option>
                </select>
                <label for="status">Status</label>
            </div>
        </div>

        <div class="form-floating" style="margin-top: 10px;">
            <textarea class="inp" id="content" name="content" placeholder="Content" style="height: 150px;" required>{{ $comment->content }}</textarea>
            <label for="content">Comment Content</label>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn p">Update Comment</button>
        </div>
    </form>
</div>

<script>
    function updateComment(e) {
        e.preventDefault();
        const data = {
            post_id: $('#post_id').val(),
            status: $('#status').val(),
            content: $('#content').val(),
            _method: 'PUT'
        };

        $.ajax({
            url: '/comments/{{ $comment->id }}',
            type: 'POST',
            data: data,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                toast('Comment updated successfully!');
                navigateTo('/comments');
            },
            error: function(err) {
                toast('Error updating comment', 'error');
            }
        });
    }
</script>
@endsection
