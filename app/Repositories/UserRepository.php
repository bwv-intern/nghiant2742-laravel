<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers($queryParams) {
        // Start building the query
        $query = User::query();

        // Check if any query parameters are provided
        if (!empty($queryParams)) {
            foreach ($queryParams as $key => $value) {
                switch ($key) {
                    case 'email':
                        // Add condition to filter by email
                        $query->where('email', $value);
                        break;
                    case 'user_flg':
                        // Change the field name from 'admin_flag' to 'user_flg'
                        $query->whereIn('user_flg', $value);
                        break;
                    case 'dateOfBirth':
                        // Add condition to filter by date of birth
                        $query->where('date_of_birth', $value);
                        break;
                    case 'name':
                        // Add condition to filter by fullname (assuming it's a partial match)
                        $query->where('name', 'like', '%' . $value . '%');
                        break;
                    case 'phone':
                        // Add condition to filter by phone
                        $query->where('phone', $value);
                        break;
                    // Add additional cases for handling other query parameters (if needed)
                }
            }
        }
        
        // Execute the query and return the result
        return $query->get();
    }


    public function getUserById($userId) 
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails) 
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails) 
    {
        return User::whereId($userId)->update($newDetails);
    }

}