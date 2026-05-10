@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-sub', 'Manage user accounts and assigned roles')

@section('content')
<div class="card" style="padding:14px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
        <div style="font-family:'Syne',sans-serif;font-size:14px;font-weight:700;">User Management</div>
        <button class="btn p" onclick="createUser()">＋ Add User</button>
    </div>

    <div style="overflow-x:auto;">
        <table id="users-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var table;
    $(function() {
        table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'roles', name: 'roles', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search users...",
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

    async function createUser() {
        const rolesRes = await fetch("{{ route('users.roles') }}");
        const roles = await rolesRes.json();
        
        let rolesHtml = roles.map(role => `
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                <input type="checkbox" name="roles[]" value="${role.name}" id="role-${role.id}" style="accent-color:var(--ac);">
                <label for="role-${role.id}" style="font-size:14px;cursor:pointer;">${role.name}</label>
            </div>
        `).join('');

        let html = `
            <form id="user-form">
                <div class="fg" style="margin-bottom:12px;">
                    <label>Full Name</label>
                    <input type="text" name="name" class="inp" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Email Address</label>
                    <input type="email" name="email" class="inp" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Password</label>
                    <input type="password" name="password" class="inp" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Assign Roles</label>
                    <div style="background:var(--gs);padding:10px;border-radius:8px;border:1px solid var(--gb);">
                        ${rolesHtml || '<span style="color:var(--tm);font-size:9px;">No roles found.</span>'}
                    </div>
                </div>
            </form>
        `;

        let footer = `
            <button class="btn" onclick="closeDrawer()">Cancel</button>
            <button class="btn p" onclick="submitUserForm()">Save User</button>
        `;

        openDrawer('Create New User', html, footer);
    }

    async function editUser(id) {
        const [userRes, rolesRes] = await Promise.all([
            fetch(`/users/${id}`),
            fetch("{{ route('users.roles') }}")
        ]);
        const user = await userRes.json();
        const roles = await rolesRes.json();
        
        const userRoleNames = user.roles.map(r => r.name);

        let rolesHtml = roles.map(role => `
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                <input type="checkbox" name="roles[]" value="${role.name}" id="role-${role.id}" 
                    ${userRoleNames.includes(role.name) ? 'checked' : ''} style="accent-color:var(--ac);">
                <label for="role-${role.id}" style="font-size:10.5px;cursor:pointer;">${role.name}</label>
            </div>
        `).join('');

        let html = `
            <form id="user-form">
                <input type="hidden" name="id" value="${user.id}">
                <div class="fg" style="margin-bottom:12px;">
                    <label>Full Name</label>
                    <input type="text" name="name" class="inp" value="${user.name}" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Email Address</label>
                    <input type="email" name="email" class="inp" value="${user.email}" required>
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="inp">
                </div>
                <div class="fg" style="margin-bottom:12px;">
                    <label>Assign Roles</label>
                    <div style="background:var(--gs);padding:10px;border-radius:8px;border:1px solid var(--gb);">
                        ${rolesHtml || '<span style="color:var(--tm);font-size:12px;">No roles found.</span>'}
                    </div>
                </div>
            </form>
        `;

        let footer = `
            <button class="btn" onclick="closeDrawer()">Cancel</button>
            <button class="btn p" onclick="submitUserForm(${user.id})">Update User</button>
        `;

        openDrawer('Edit User', html, footer);
    }

    async function viewUser(id) {
        const res = await fetch(`/users/${id}`);
        const user = await res.json();
        
        let rolesHtml = user.roles.map(r => `<span class="bdg bu" style="margin-right:4px;">${r.name}</span>`).join('') || 'No roles assigned';

        let html = `
            <div style="display:flex;flex-direction:column;gap:15px;">
                <div>
                    <label style="font-size:9px;color:var(--tm);text-transform:uppercase;letter-spacing:1px;">Name</label>
                    <div style="font-size:15px;font-weight:600;">${user.name}</div>
                </div>
                <div>
                    <label style="font-size:9px;color:var(--tm);text-transform:uppercase;letter-spacing:1px;">Email</label>
                    <div style="font-size:15px;font-weight:600;">${user.email}</div>
                </div>
                <div>
                    <label style="font-size:9px;color:var(--tm);text-transform:uppercase;letter-spacing:1px;">Roles</label>
                    <div style="margin-top:5px;">${rolesHtml}</div>
                </div>
                <div>
                    <label style="font-size:12px;color:var(--tm);text-transform:uppercase;letter-spacing:1px;">Joined</label>
                    <div style="font-size:14px;">${new Date(user.created_at).toLocaleDateString()}</div>
                </div>
            </div>
        `;

        openDrawer('User Details', html, `<button class="btn" onclick="closeDrawer()">Close</button>`);
    }

    async function submitUserForm(id = null) {
        const form = document.getElementById('user-form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Handle multiple checkboxes for roles
        data.roles = Array.from(form.querySelectorAll('input[name="roles[]"]:checked')).map(cb => cb.value);

        const url = id ? `/users/${id}` : '/users';
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
                table.ajax.reload();
            } else {
                toast(result.message || 'Something went wrong', 'error');
            }
        } catch (err) {
            toast('Network error', 'error');
        }
    }

    function deleteUser(id) {
        confirmAction('Are you sure you want to delete this user? This action cannot be undone.', () => {
            fetch(`/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => res.json()).then(res => {
                toast(res.message);
                table.ajax.reload();
            }).catch(() => toast('Error deleting user', 'error'));
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
        font-size: 12px !important;
        margin-bottom: 10px;
    }
    table.dataTable thead th {
        border-bottom: 1px solid var(--gb) !important;
        color: var(--tm) !important;
        font-weight: 500 !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    table.dataTable tbody tr {
        background-color: transparent !important;
        color: var(--tp) !important;
    }
    table.dataTable tbody td {
        border-top: 1px solid var(--gb) !important;
        padding: 10px 8px !important;
        font-size: 14px;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid var(--gb) !important;
    }
    .dataTables_filter input {
        margin-left: 10px !important;
    }
</style>
@endsection
