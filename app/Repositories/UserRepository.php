<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function list($request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';
        $searchName = $request->searchName;
        $searchUsername = $request->searchUsername;
        $searchEmail = $request->searchEmail;
        $searchStatus = $request->searchStatus;

        $usersBuilder = User::when($searchName, function ($query) use ($searchName) {
            $query->where('name', 'like', "%$searchName%");
        })
        ->when($searchUsername, function ($query) use ($searchUsername) {
            $query->where('username', 'like', "%$searchUsername%");
        })
        ->when($searchEmail, function ($query) use ($searchEmail) {
            $query->where('email', 'like', "%$searchEmail%");
        })
        ->when($searchStatus, function ($query) use ($searchStatus) {
            $query->where('status', $searchStatus);
        })
        ->orderBy($sort, $order);

        if (isset($offset) && isset($limit)) {
            // Get the total number of records, regardless of pagination or filtering.
            $userNotFiltered = User::count();

            $users = $usersBuilder->paginate($limit, ['*'], 'page', $page);

            $data = [
                'total' => $users->total(),
                'totalNotFiltered' => $userNotFiltered,
                'rows' => $users->items(),
            ];

            return $data;
        }

        $users = $usersBuilder->get();

        return $users;
    }

    public function details($request, $id)
    {
        return User::findOrFail($id);
    }
}