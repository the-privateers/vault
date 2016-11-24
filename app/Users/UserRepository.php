<?php

namespace Vault\Users;


use Vault\Uuid\UuidRepositoryTrait;
use Vault\Vaults\Vault;

class UserRepository
{
    use UuidRepositoryTrait;

    public function create($formData)
    {
        $user = User::create($formData);
        
        return $user;
    }

    public function update($user, $formData)
    {
        if(empty($formData['password']))
        {
            unset($formData['password']);
        } else
        {
            $formData['password'] = bcrypt($formData['password']);
        }

        $user->fill($formData);

        $user->save();

        return $user;
    }
}