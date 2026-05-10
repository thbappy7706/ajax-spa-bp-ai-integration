@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Posts</h1>
        <div class="psub">Manage blog posts and articles.</div>
    </div>
    <div style="display: flex; gap: 10px;">
        <select id="statusFilter" class="inp" style="width: 150px;" onchange="postsTable.ajax.reload()">
            <option value="">All Statuses</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>
        <button class="btn p" onclick="createPost()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Create Post
        </button>
    </div>
</div>

<div class="card fi" style="padding: 20px;">
    <table id="postsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var postsTable;
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#postsTable')) {
            $('#postsTable').DataTable().destroy();
        }
        postsTable = $('#postsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/posts',
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'category.name', name: 'category.name', defaultContent: 'Uncategorized' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search posts..."
            }
        });
    });

    function getPostFormHtml(categories, post = null) {
        const isEdit = !!post;
        let catOptions = '<option value="" disabled selected>Select Category</option>';
        categories.forEach(c => {
            const sel = (isEdit && post.category_id == c.id) ? 'selected' : '';
            catOptions += `<option value="${c.id}" ${sel}>${c.name}</option>`;
        });

        return `
            <form id="postForm" onsubmit="submitPost(event, ${isEdit ? post.id : 'null'})">
                <div class="form-floating">
                    <input type="text" class="inp" id="title" name="title" placeholder="Title" value="${isEdit ? post.title : ''}" required>
                    <label for="title">Post Title</label>
                </div>

                <div class="frow">
                    <div class="form-floating">
                        <select class="inp" id="category_id" name="category_id" required>
                            ${catOptions}
                        </select>
                        <label for="category_id">Category</label>
                    </div>
                    <div class="form-floating">
                        <select class="inp" id="status" name="status" required>
                            <option value="draft" ${isEdit && post.status === 'draft' ? 'selected' : ''}>Draft</option>
                            <option value="published" ${isEdit && post.status === 'published' ? 'selected' : ''}>Published</option>
                            <option value="archived" ${isEdit && post.status === 'archived' ? 'selected' : ''}>Archived</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>

                <div class="form-floating" style="margin-top: 10px;">
                    <textarea class="inp" id="content" name="content" placeholder="Content" style="height: 200px;" required>${isEdit && post.content ? post.content : ''}</textarea>
                    <label for="content">Post Content</label>
                </div>
            </form>
        `;
    }

    function createPost() {
        fetch('/posts/create', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                const body = getPostFormHtml(data.categories);
                const footer = `
                    <button class="btn" onclick="closeModal(this)">Cancel</button>
                    <button class="btn p" onclick="document.getElementById('postForm').requestSubmit()">Save Post</button>
                `;
                openModal('Create Post', body, footer, true); // xl modal
            });
    }

    function editPost(id) {
        fetch('/posts/' + id + '/edit', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                const body = getPostFormHtml(data.categories, data.post);
                const footer = `
                    <button class="btn" onclick="closeModal(this)">Cancel</button>
                    <button class="btn p" onclick="document.getElementById('postForm').requestSubmit()">Update Post</button>
                `;
                openModal('Edit Post', body, footer, true); // xl modal
            });
    }

    function submitPost(e, id) {
        e.preventDefault();
        const data = {
            title: $('#title').val(),
            category_id: $('#category_id').val(),
            status: $('#status').val(),
            content: $('#content').val()
        };

        let url = '/posts';
        let type = 'POST';

        if (id) {
            url = '/posts/' + id;
            data._method = 'PUT';
        }

        $.ajax({
            url: url,
            type: type,
            data: data,
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function(res) {
                toast('Post saved successfully!');
                closeModal(document.getElementById('postForm'));
                postsTable.ajax.reload();
            },
            error: function(err) {
                toast('Error saving post', 'error');
            }
        });
    }

    // Since datatables loads action links with navigateTo('/posts/1/edit'), 
    // we need to override the datatable action column rendered from backend.
    // We will fix the action column in backend, but for now we define:
    window.editPostAction = function(id) { editPost(id); }

    function deletePost(id) {
        confirmAction('Are you sure you want to delete this post?', () => {
            $.ajax({
                url: '/posts/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
                success: function(res) {
                    toast('Post deleted successfully');
                    postsTable.ajax.reload();
                }
            });
        });
    }
</script>
@endsection
