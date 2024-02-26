<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Customer;
use App\Interfaces\CustomerRepositoryInterface;

class UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->tokens()->count() > 0) {
            $user->tokens()->delete();
        }

        return $user->delete();
    }
}
