<?php

namespace App\Exports;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\ConstUtil;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    //assign headers
    public function headings(): array {
        return [
            'user_id',
            'email',
            'name',
            'user_flg',
            'date_of_birth',
            'phone',
            'address',
            'del_flg',
            'created_by',
            'created_at'
        ];
    }

    public function collection() {
        $userRepository = new UserRepository(new User);
        if (request()->session()->exists('userQueryParams')) {
            // get data users from session
            $userQueryParams = Session::get('userQueryParams');
            // search and get users
            $users = (Object) $userRepository->search($userQueryParams);
            return $users->get();
        } else {
            $delFlg = ConstUtil::getContentYml('common', 'del_flg', 'no');
            // return default users
            return User::where('del_flg', $delFlg)->get();
        }
    }


    public function map($user): array {
        return [
            $user->id,
            $user->email,
            $user->name,
            ConstUtil::getContentYml('users','user_flg', $user->user_flg),
            Carbon::parse($user->date_of_birth)->format('Y-m-d'),
            $user->phone,
            $user->address,
            strval($user->del_flg),
            strval($user->created_by),
            $user->created_at
        ];
    }

}
