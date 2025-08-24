<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'country_code' => 'required|string|max:10',
            'role' => 'required|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country_code' => $request->country_code,
            'password' => Hash::make($request->password),
            'status' => true,
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile_images', $imageName);
            $userData['profile_image'] = 'storage/profile_images/' . $imageName;
        }

        $user = User::create($userData);
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'country_code' => 'required|string|max:10',
            'role' => 'required|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country_code' => $request->country_code,
        ];

        // Handle password update
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists(str_replace('storage/', 'public/', $user->profile_image))) {
                Storage::delete(str_replace('storage/', 'public/', $user->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile_images', $imageName);
            $userData['profile_image'] = 'storage/profile_images/' . $imageName;
        }

        $user->update($userData);
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Don't allow deletion of super-admin users
        if ($user->hasRole('super-admin')) {
            return redirect()->route('users.index')->with('error', 'Cannot delete super-admin user!');
        }

        // Delete profile image if exists
        if ($user->profile_image && Storage::exists(str_replace('storage/', 'public/', $user->profile_image))) {
            Storage::delete(str_replace('storage/', 'public/', $user->profile_image));
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        // Don't allow deactivating super-admin users
        if ($user->hasRole('super-admin')) {
            return redirect()->route('users.index')->with('error', 'Cannot deactivate super-admin user!');
        }

        $user->update(['status' => !$user->status]);
        $status = $user->status ? 'activated' : 'deactivated';
        
        return redirect()->route('users.index')->with('success', "User {$status} successfully!");
    }
}
