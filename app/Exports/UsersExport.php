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
    public function headings(): array
    {
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

    public function collection()
    {
        $userRepository = new UserRepository(new User);
        if (request()->session()->exists('queryParams')) {
            // get data users from session
            $queryParams = Session::get('queryParams');
            // search and get users
            $users = (Object) $userRepository->search($queryParams);
            return $users->get();
        } else {
            $del_flg = ConstUtil::getContentYml('common', 'del_flg');
            // return default users
            return User::where('del_flg', $del_flg)->get();
        }
    }


    public function map($user): array
    {
        return [
            $user->user_id,
            $user->email,
            $user->name,
            strval($user->user_flg),
            Carbon::parse($user->date_of_birth)->format('Y-m-d'),
            $user->phone,
            $user->address,
            strval($user->del_flg),
            strval($user->created_by),
            $user->created_at
        ];
    }

}
