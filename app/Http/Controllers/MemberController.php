<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MemberRepository;
use App\Http\Requests\UpsertMemberRequest;

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
    public function store(UpsertMemberRequest $request)
    {
        Member::create([
            'uuid' => (string) Str::uuid(),
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'status' => $request->status,
        ]);

        return to_route('members.index')->with('success', 'Member created successfully.');
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
    public function update(UpsertMemberRequest $request, string $id)
    {
        $member = Member::findOrFail($id);

        $member->username = $request->username;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->email = $request->email;
        $member->phone_number = $request->phone_number;
        $member->date_of_birth = $request->date_of_birth;
        $member->gender = $request->gender;
        $member->status = $request->status;

        if (!empty($request->password)) {
            $member->password = Hash::make($request->password);
        }

        $member->save();

        return to_route('members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Member::destroy($id);

        return to_route('members.index')->with('success', 'Member deleted successfully.');
    }
}
