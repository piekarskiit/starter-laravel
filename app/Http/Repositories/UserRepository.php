<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function list()
    {
        return User::with('roles')->paginate();
    }

    public function store(array $data): User
    {
        $role = $data['role'];
        unset($data['role']);
        $user = User::create($data);

        return $user->assignRole($role);
    }

    public function update(User $user, array $data): bool
    {
        $role = $data['role'];
        unset($data['role']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $user->syncRoles($role)->update($data);
    }

    public function destroy(User $user): bool
    {
        return $user->delete();
    }

}
