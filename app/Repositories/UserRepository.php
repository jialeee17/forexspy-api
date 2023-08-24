<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function list($request)
    {
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'asc';
        $offset = $request->offset;
        $limit = $request->limit;
        $page = $offset == 0 ? 1 : ($offset / $limit) + 1; // The page number to use as the starting point for pagination.

        // Get the total number of records, regardless of pagination or filtering.
        $userNotFiltered = User::count();

        $users = User::when($sort, function ($query) use ($sort, $order) {
            $query->orderBy($sort, $order);
        })->paginate($limit, ['*'], 'page', $page);

        $data = [
            'total' => $users->total(),
            'totalNotFiltered' => $userNotFiltered,
            'rows' => $users->items(),
        ];

        return $data;
    }

    public function details($request, $id)
    {
        $user = User::find($id);
        return $user;
    }
}