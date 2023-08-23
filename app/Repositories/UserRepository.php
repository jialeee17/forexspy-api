<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function list ($request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.

        // Get the total number of records, regardless of pagination or filtering.
        $userNotFiltered = User::count();

        $users = User::paginate($limit, ['*'], 'page', $page);

        $data = [
            'total' => $users->total(),
            'totalNotFiltered' => $userNotFiltered,
            'rows' => $users->items(),
        ];

        return $data;
    }
}