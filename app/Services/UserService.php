<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\UserReadableInterface;
use App\Interfaces\UserWritableInterface;
use App\Interfaces\UserDeletableInterface;

class UserService implements UserReadableInterface, UserWritableInterface, UserDeletableInterface
{
    public function getAllUsers()
    {
        return User::select('id', 'name', 'email', 'created_at')->paginate(10);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function updateUser(array $data, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
