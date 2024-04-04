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
    public function __construct(User $model) {
        $this->model = $model;
    }

    public function search($queryParams) {
        $delFlg = ConstUtil::getContentYml('common', 'del_flg', 'no');
        
        $users = User::where('del_flg', $delFlg);
        if (isset($queryParams['email'])) {
            $users = $users->where('email', $queryParams['email']);
        }
        if (isset($queryParams['user_flg'])) {
            $users = $users->whereIn('user_flg', $queryParams['user_flg']);
        }
        if (isset($queryParams['name'])) {
            $users = $users->where('name', 'LIKE', "%" . $queryParams['name'] . "%");
        }
        if (isset($queryParams['date_of_birth'])) {
            $users = $users->where('date_of_birth', $queryParams['date_of_birth']);
        }
        if (isset($queryParams['phone'])) {
            $users = $users->where('phone', $queryParams['phone']);
        }
        return $users;
    }
}