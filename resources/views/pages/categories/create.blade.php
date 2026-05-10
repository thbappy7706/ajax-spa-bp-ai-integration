@extends('layouts.app')
@section('title', 'Create Category')
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
        <h1 class="ptitle">Create Category</h1>
        <div class="psub">Add a new post category.</div>
    </div>
    <button class="btn" onclick="navigateTo('/categories')">Back to Categories</button>
</div>

<div class="card fi" style="max-width: 900px; margin: 0 auto; padding: 30px;">
    <form id="categoryForm" onsubmit="submitCategory(event)">
        <div class="frow">
            <div class="form-floating">
                <input type="text" class="inp" id="name" name="name" placeholder="Name" required>
                <label for="name">Category Name</label>
            </div>
            <div class="form-floating">
                <select class="inp" id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <label for="status">Status</label>
            </div>
        </div>

        <div class="form-floating" style="margin-top: 10px;">
            <textarea class="inp" id="description" name="description" placeholder="Description" style="height: 120px;"></textarea>
            <label for="description">Description</label>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn p">Save Category</button>
        </div>
    </form>
</div>

<script>
    function submitCategory(e) {
        e.preventDefault();
        const data = {
            name: $('#name').val(),
            status: $('#status').val(),
            description: $('#description').val(),
        };

        $.ajax({
            url: '/categories',
            type: 'POST',
            data: data,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                toast('Category created successfully!');
                navigateTo('/categories');
            },
            error: function(err) {
                toast('Error saving category', 'error');
            }
        });
    }
</script>
@endsection
