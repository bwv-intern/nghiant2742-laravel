<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Utils\ConstUtil;

class UserRepository extends BaseRepository implements UserRepositoryInterface 
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function search($queryParams) {
        $del_flg = ConstUtil::getContentYml('common', 'del_flg');
        // dd($queryParams);
        $users = User::where('del_flg', $del_flg);
        if (isset($queryParams['email'])) {
            $users = $users->where('email', $queryParams['email']);
        }
        if (isset($queryParams['user_flg'])) {
            $users = $users->whereIn('user_flg', $queryParams['user_flg']);
        }
        if (isset($queryParams['name'])) {
            $users = $users->where('name', 'LIKE', "%" . $queryParams['name'] . "%");
        }
        if (isset($queryParams['dateOfBirth'])) {
            $users = $users->where('date_of_birth', $queryParams['dateOfBirth']);
        }
        if (isset($queryParams['phone'])) {
            $users = $users->where('phone', $queryParams['phone']);
        }
        return $users;
    }
}