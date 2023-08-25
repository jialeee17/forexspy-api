<?php

namespace App\Repositories;

use App\Models\Member;
use App\Interfaces\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    public function list($request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';
        $searchUuid = $request->searchUuid;
        $searchUsername = $request->searchUsername;
        $searchEmail = $request->searchEmail;
        $searchFirstName = $request->searchFirstName;
        $searchLastName = $request->searchLastName;
        $searchPhoneNumber = $request->searchPhoneNumber;
        $searchDateOfBirth = $request->searchDateOfBirth;
        $searchGender = $request->searchGender;
        $searchStatus = $request->searchStatus;

        $membersBuilder = Member::when($searchUuid, function ($query) use ($searchUuid) {
            $query->where('uuid', $searchUuid);
        })
        ->when($searchUsername, function ($query) use ($searchUsername) {
            $query->where('username', 'like', "%$searchUsername%");
        })
        ->when($searchEmail, function ($query) use ($searchEmail) {
            $query->where('email', 'like', "%$searchEmail%");
        })
        ->when($searchFirstName, function ($query) use ($searchFirstName) {
            $query->where('first_name', 'like', "%$searchFirstName%");
        })
        ->when($searchLastName, function ($query) use ($searchLastName) {
            $query->where('last_name', 'like', "%$searchLastName%");
        })
        ->when($searchPhoneNumber, function ($query) use ($searchPhoneNumber) {
            $query->where('phone_number', 'like', "%$searchPhoneNumber%");
        })
        ->when($searchDateOfBirth, function ($query) use ($searchDateOfBirth) {
            $query->whereDate('date_of_birth', $searchDateOfBirth);
        })
        ->when($searchGender, function ($query) use ($searchGender) {
            $query->where('gender', $searchGender);
        })
        ->when($searchStatus, function ($query) use ($searchStatus) {
            $query->where('status', $searchStatus);
        })
        ->orderBy($sort, $order);

        if (isset($offset) && isset($limit)) {
            // Get the total number of records, regardless of pagination or filtering.
            $memberNotFiltered = Member::count();

            $members = $membersBuilder->paginate($limit, ['*'], 'page', $page);

            $data = [
                'total' => $members->total(),
                'totalNotFiltered' => $memberNotFiltered,
                'rows' => $members->items(),
            ];

            return $data;
        }

        $members = $membersBuilder->get();

        return $members;
    }
}