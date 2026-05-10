<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('draw')) {
                $roles = Role::with('permissions')->select('roles.*');
                return DataTables::of($roles)
                    ->addColumn('permissions', function (Role $role) {
                        return $role->permissions->pluck('name')->map(function ($perm) {
                            return '<span class="bdg bg" style="margin-right:2px;font-size:8px;">' . $perm . '</span>';
                        })->implode('');
                    })
                    ->addColumn('actions', function (Role $role) {
                        return '<div style="display:flex;gap:3px;">
                            <button class="btn" onclick="editRole(' . $role->id . ')" style="padding:2px 7px;font-size:9px;">Edit</button>
                            <button class="btn d" onclick="deleteRole(' . $role->id . ')" style="padding:2px 7px;font-size:9px;">Del</button>
                        </div>';
                    })
                    ->rawColumns(['permissions', 'actions'])
                    ->make(true);
            }
            return view('pages.roles')->renderSections()['content'];
        }

        return view('pages.roles');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:roles',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $validated['name']]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json(['message' => 'Role created successfully', 'role' => $role]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return response()->json(['message' => 'Role updated successfully', 'role' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    /**
     * Get all permissions.
     */
    public function getPermissions()
    {
        return response()->json(Permission::all());
    }
}
