<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::get();

        return Inertia::render('Member/Index', [
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Member/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:members'],
            'password' => ['required', 'string'],
            'email' => ['required', 'email', 'max:50', 'unique:members'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
        ]);

        Member::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return to_route('members.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::find($id);

        return Inertia::render('Member/Show', [
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = Member::find($id);

        return Inertia::render('Member/Edit', [
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:members'],
            'password' => ['required', 'string'],
            'email' => ['required', 'email', 'max:50', 'unique:members'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
        ]);

        Member::where('id', $id)
            ->update([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
            ]);

        return to_route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Member::destroy($id);

        return to_route('members.index');
    }
}
