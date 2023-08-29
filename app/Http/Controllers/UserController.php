<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpsertUserRequest;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return to_route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $user = User::find($id);

        // return Inertia::render('User/Show', [
        //     'user' => $user
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $user = User::find($id);

        // return Inertia::render('User/Edit', [
        //     'user' => $user
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertUserRequest $request, string $id)
    {
        User::where('id', $id)
            ->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'status' => $request->status,
                // 'password' => Hash::make($request->password),
            ]);

        return to_route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return to_route('users.index')->with('success', 'User deleted successfully.');
    }
}
