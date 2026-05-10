@extends('layouts.app')

@section('title', 'Roles')
@section('page-title', 'Roles')
@section('page-sub', 'Manage system roles and their permissions')

@section('content')
<div class="card" style="padding:14px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
        <div style="font-family:'Syne',sans-serif;font-size:11px;font-weight:700;">Role Management</div>
        <button class="btn p" onclick="createRole()">＋ Add Role</button>
    </div>

    <div style="overflow-x:auto;">
        <table id="roles-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var roleTable;
    $(function() {
        roleTable = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'permissions', name: 'permissions', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search roles...",
                lengthMenu: "_MENU_ per page",
                paginate: {
                    previous: "‹",
                    next: "›"
                }
            },
            drawCallback: function() {
                $('.dataTables_paginate .paginate_button').addClass('pb');
                $('.dataTables_filter input').addClass('inp');
                $('.dataTables_length select').addClass('inp');
            }
        });
    });

    async function createRole() {
        const permsRes = await fetch("{{ route('roles.permissions') }}");
        const perms = await permsRes.json();
        
        let permsHtml = perms.map(p => `
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;width:50%;float:left;">
                <input type="checkbox" name="permissions[]" value="${p.name}" id="perm-${p.id}" style="accent-color:var(--ac);">
                <label for="perm-${p.id}" style="font-size:10px;cursor:pointer;">${p.name}</label>
            </div>
        `).join('');

        let html = `
            <form id="role-form">
                <div class="fg" style="margin-bottom:12px;">
                    <label>Role Name</label>
                    <input type="text" name="name" class="inp" placeholder="e.g. Moderator" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Assign Permissions</label>
                    <div style="background:var(--gs);padding:10px;border-radius:8px;border:1px solid var(--gb);overflow:hidden;">
                        ${permsHtml || '<span style="color:var(--tm);font-size:9px;">No permissions found.</span>'}
                    </div>
                </div>
            </form>
        `;

        let footer = `
            <button class="btn" onclick="closeDrawer()">Cancel</button>
            <button class="btn p" onclick="submitRoleForm()">Save Role</button>
        `;

        openDrawer('Create New Role', html, footer);
    }

    async function editRole(id) {
        const [roleRes, permsRes] = await Promise.all([
            fetch(`/roles/${id}`),
            fetch("{{ route('roles.permissions') }}")
        ]);
        const role = await roleRes.json();
        const perms = await permsRes.json();
        
        const rolePermNames = role.permissions.map(p => p.name);

        let permsHtml = perms.map(p => `
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;width:50%;float:left;">
                <input type="checkbox" name="permissions[]" value="${p.name}" id="perm-${p.id}" 
                    ${rolePermNames.includes(p.name) ? 'checked' : ''} style="accent-color:var(--ac);">
                <label for="perm-${p.id}" style="font-size:10px;cursor:pointer;">${p.name}</label>
            </div>
        `).join('');

        let html = `
            <form id="role-form">
                <div class="fg" style="margin-bottom:12px;">
                    <label>Role Name</label>
                    <input type="text" name="name" class="inp" value="${role.name}" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Assign Permissions</label>
                    <div style="background:var(--gs);padding:10px;border-radius:8px;border:1px solid var(--gb);overflow:hidden;">
                        ${permsHtml || '<span style="color:var(--tm);font-size:9px;">No permissions found.</span>'}
                    </div>
                </div>
            </form>
        `;

        let footer = `
            <button class="btn" onclick="closeDrawer()">Cancel</button>
            <button class="btn p" onclick="submitRoleForm(${role.id})">Update Role</button>
        `;

        openDrawer('Edit Role', html, footer);
    }

    async function submitRoleForm(id = null) {
        const form = document.getElementById('role-form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        data.permissions = Array.from(form.querySelectorAll('input[name="permissions[]"]:checked')).map(cb => cb.value);

        const url = id ? `/roles/${id}` : '/roles';
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (res.ok) {
                toast(result.message);
                closeDrawer();
                roleTable.ajax.reload();
            } else {
                toast(result.message || 'Error saving role', 'error');
            }
        } catch (err) {
            toast('Network error', 'error');
        }
    }

    function deleteRole(id) {
        confirmAction('Delete this role? Users with this role will lose its permissions.', () => {
            fetch(`/roles/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => res.json()).then(res => {
                toast(res.message);
                roleTable.ajax.reload();
            }).catch(() => toast('Error deleting role', 'error'));
        });
    }
</script>

<style>
    /* DataTables Overrides for Nexus Theme */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter, 
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_processing, 
    .dataTables_wrapper .dataTables_paginate {
        color: var(--tm) !important;
        font-size: 10px !important;
        margin-bottom: 10px;
    }
    table.dataTable thead th {
        border-bottom: 1px solid var(--gb) !important;
        color: var(--tm) !important;
        font-weight: 500 !important;
        text-transform: uppercase;
        font-size: 9px;
        letter-spacing: 0.5px;
    }
    table.dataTable tbody tr {
        background-color: transparent !important;
        color: var(--tp) !important;
    }
    table.dataTable tbody td {
        border-top: 1px solid var(--gb) !important;
        padding: 10px 8px !important;
        font-size: 10.5px;
    }
</style>
@endsection
