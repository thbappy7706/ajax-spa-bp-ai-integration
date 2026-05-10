@extends('layouts.app')
@section('title', 'Comments')
@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Comments</h1>
        <div class="psub">Manage user comments.</div>
    </div>
    <div style="display: flex; gap: 10px;">
        <select id="statusFilter" class="inp" style="width: 150px;" onchange="commentsTable.ajax.reload()">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="spam">Spam</option>
            <option value="trashed">Trashed</option>
        </select>
        <button class="btn p" onclick="createComment()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Add Comment
        </button>
    </div>
</div>

<div class="card fi" style="padding: 20px;">
    <table id="commentsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Post</th>
                <th>User</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var commentsTable;
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#commentsTable')) {
            $('#commentsTable').DataTable().destroy();
        }
        commentsTable = $('#commentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/comments',
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'post.title', name: 'post.title', defaultContent: 'N/A' },
                { data: 'user.name', name: 'user.name', defaultContent: 'Anonymous' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search comments..."
            }
        });
    });

    function getCommentFormHtml(posts, comment = null) {
        const isEdit = !!comment;
        let postOptions = '<option value="" disabled selected>Select Post</option>';
        posts.forEach(p => {
            const sel = (isEdit && comment.post_id == p.id) ? 'selected' : '';
            postOptions += `<option value="${p.id}" ${sel}>${p.title}</option>`;
        });

        return `
            <form id="commentForm" onsubmit="submitComment(event, ${isEdit ? comment.id : 'null'})">
                <div class="frow">
                    <div class="form-floating">
                        <select class="inp" id="post_id" name="post_id" required>
                            ${postOptions}
                        </select>
                        <label for="post_id">Post</label>
                    </div>
                    <div class="form-floating">
                        <select class="inp" id="status" name="status" required>
                            <option value="pending" ${isEdit && comment.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="approved" ${isEdit && comment.status === 'approved' ? 'selected' : ''}>Approved</option>
                            <option value="spam" ${isEdit && comment.status === 'spam' ? 'selected' : ''}>Spam</option>
                            <option value="trashed" ${isEdit && comment.status === 'trashed' ? 'selected' : ''}>Trashed</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>

                <div class="form-floating" style="margin-top: 10px;">
                    <textarea class="inp" id="content" name="content" placeholder="Content" style="height: 150px;" required>${isEdit && comment.content ? comment.content : ''}</textarea>
                    <label for="content">Comment Content</label>
                </div>
            </form>
        `;
    }

    function createComment() {
        fetch('/comments/create', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                const body = getCommentFormHtml(data.posts);
                const footer = `
                    <button class="btn" onclick="closeModal(this)">Cancel</button>
                    <button class="btn p" onclick="document.getElementById('commentForm').requestSubmit()">Save Comment</button>
                `;
                openModal('Add Comment', body, footer, true); // xl modal
            });
    }

    function editComment(id) {
        fetch('/comments/' + id + '/edit', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                const body = getCommentFormHtml(data.posts, data.comment);
                const footer = `
                    <button class="btn" onclick="closeModal(this)">Cancel</button>
                    <button class="btn p" onclick="document.getElementById('commentForm').requestSubmit()">Update Comment</button>
                `;
                openModal('Edit Comment', body, footer, true); // xl modal
            });
    }

    function submitComment(e, id) {
        e.preventDefault();
        const data = {
            post_id: $('#post_id').val(),
            status: $('#status').val(),
            content: $('#content').val()
        };

        let url = '/comments';
        let type = 'POST';

        if (id) {
            url = '/comments/' + id;
            data._method = 'PUT';
        }

        $.ajax({
            url: url,
            type: type,
            data: data,
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function(res) {
                toast('Comment saved successfully!');
                closeModal(document.getElementById('commentForm'));
                commentsTable.ajax.reload();
            },
            error: function(err) {
                toast('Error saving comment', 'error');
            }
        });
    }

    window.editCommentAction = function(id) { editComment(id); }

    function deleteComment(id) {
        confirmAction('Are you sure you want to delete this comment?', () => {
            $.ajax({
                url: '/comments/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
                success: function(res) {
                    toast('Comment deleted successfully');
                    commentsTable.ajax.reload();
                }
            });
        });
    }
</script>
@endsection
