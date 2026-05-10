<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('draw')) {
                $users = User::with('roles')->select('users.*');
                return DataTables::of($users)
                    ->addColumn('roles', function (User $user) {
                        return $user->roles->pluck('name')->map(function ($role) {
                            return '<span class="bdg bu" style="margin-right:2px;">' . $role . '</span>';
                        })->implode('');
                    })
                    ->addColumn('actions', function (User $user) {
                        return '<div style="display:flex;gap:3px;">
                            <button class="btn" onclick="viewUser(' . $user->id . ')" style="padding:2px 7px;font-size:9px;">View</button>
                            <button class="btn" onclick="editUser(' . $user->id . ')" style="padding:2px 7px;font-size:9px;">Edit</button>
                            <button class="btn d" onclick="deleteUser(' . $user->id . ')" style="padding:2px 7px;font-size:9px;">Del</button>
                        </div>';
                    })
                    ->rawColumns(['roles', 'actions'])
                    ->make(true);
            }
            return view('pages.users')->renderSections()['content'];
        }

        return view('pages.users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles'    => 'nullable|array',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles'    => 'nullable|array',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles($validated['roles'] ?? []);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Get roles for selection.
     */
    public function getRoles()
    {
        return response()->json(Role::all());
    }
}
