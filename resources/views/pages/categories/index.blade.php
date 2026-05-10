@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Categories</h1>
        <div class="psub">Manage post categories.</div>
    </div>
    <div style="display: flex; gap: 10px;">
        <select id="statusFilter" class="inp" style="width: 150px;" onchange="categoriesTable.ajax.reload()">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button class="btn p" onclick="createCategory()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Create Category
        </button>
    </div>
</div>

<div class="card fi" style="padding: 20px;">
    <table id="categoriesTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var categoriesTable;
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#categoriesTable')) {
            $('#categoriesTable').DataTable().destroy();
        }
        categoriesTable = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/categories',
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'slug', name: 'slug' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search categories..."
            }
        });
    });

    function getCategoryFormHtml(category = null) {
        const isEdit = !!category;
        return `
            <form id="categoryForm" onsubmit="submitCategory(event, ${isEdit ? category.id : 'null'})">
                <div class="frow">
                    <div class="form-floating">
                        <input type="text" class="inp" id="name" name="name" placeholder="Name" value="${isEdit ? category.name : ''}" required>
                        <label for="name">Category Name</label>
                    </div>
                    <div class="form-floating">
                        <select class="inp" id="status" name="status" required>
                            <option value="active" ${isEdit && category.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${isEdit && category.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
                <div class="form-floating" style="margin-top: 10px;">
                    <textarea class="inp" id="description" name="description" placeholder="Description" style="height: 120px;">${isEdit && category.description ? category.description : ''}</textarea>
                    <label for="description">Description</label>
                </div>
            </form>
        `;
    }

    function createCategory() {
        const body = getCategoryFormHtml();
        const footer = `
            <button class="btn" onclick="closeModal(this)">Cancel</button>
            <button class="btn p" onclick="document.getElementById('categoryForm').requestSubmit()">Save Category</button>
        `;
        openModal('Create Category', body, footer);
    }

    function editCategory(id) {
        // Fetch category data
        fetch('/categories/' + id + '/edit', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                const body = getCategoryFormHtml(data.category);
                const footer = `
                    <button class="btn" onclick="closeModal(this)">Cancel</button>
                    <button class="btn p" onclick="document.getElementById('categoryForm').requestSubmit()">Update Category</button>
                `;
                openModal('Edit Category', body, footer);
            });
    }

    function submitCategory(e, id) {
        e.preventDefault();
        const data = {
            name: $('#name').val(),
            status: $('#status').val(),
            description: $('#description').val()
        };
        
        let url = '/categories';
        let type = 'POST';

        if (id) {
            url = '/categories/' + id;
            data._method = 'PUT';
        }

        $.ajax({
            url: url,
            type: type,
            data: data,
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function(res) {
                toast('Category saved successfully!');
                closeModal(document.getElementById('categoryForm'));
                categoriesTable.ajax.reload();
            },
            error: function(err) {
                toast('Error saving category', 'error');
            }
        });
    }

    function deleteCategory(id) {
        confirmAction('Are you sure you want to delete this category?', () => {
            $.ajax({
                url: '/categories/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF },
                success: function(res) {
                    toast('Category deleted successfully');
                    categoriesTable.ajax.reload();
                }
            });
        });
    }
</script>
@endsection
