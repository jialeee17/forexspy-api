<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::role(['admin', 'super-admin', 'support'])->paginate(10)->through(fn ($user) => [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'name' => $user->name,
            'country' => $user->country,
            'email' => $user->email,
            'dob' => $user->dob,
            'role' => $user->getRoleNames()->first()
        ]);

        return Inertia::render('Admin/Admin/Index', [
            'admins' => $data,
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Admin/Admin/Create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $defaultDob = Carbon::now()->format('Y-m-d');

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'dob' => $defaultDob,
            'country' => 'my' // WARNING: hardcode data
        ]);
        $user->assignRole($data['role']);

        sleep(1);
        return redirect()->route('admin.admin.index')->with('success', 'Admin Created Successfully!');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return Inertia::render('Admin/Admin/Edit', [
            'roles' => $roles,
            'role' => $user->getRoleNames()->first(),
            'admin' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'role' => 'required|string'
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        $user->assignRole($data['role']);

        sleep(1);
        return redirect()->route('admin.admin.index')->with('success', 'Admin Updated Successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.admin.index')->with('success', 'Admin Deleted Successfully!');
    }

    public function password(User $user)
    {
        return Inertia::render('Admin/Admin/ChangePassword', [
            'admin' => $user
        ]);
    }

    public function update_password(Request $request, User $user)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|min:8|string',
        ]);

        $user->update([
            'password' => bcrypt($data['password'])
        ]);

        sleep(1);
        return redirect()->route('admin.admin.index')->with('success', 'Admin Password Changed Successfully!');
    }
}
