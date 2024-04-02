<?php

namespace App\Services;

use App\Utils\ConstUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // Declare the function as static
    public static function getValueCheckbox()
    {
        $lengthOfList = ConstUtil::getLengthOfContentYml('users','user_flg');
        $checkboxList = [
            ['id' => 'adminFlag', 'value' => '0', 'label' => 'Admin', 'checked' => true],
            ['id' => 'userFlag', 'value' => '1', 'label' => 'User', 'checked' => true],
            ['id' => 'supportFlag', 'value' => '2', 'label' => 'Support', 'checked' => true],
        ];
        $options = [];

        if($lengthOfList === null) return $options;
        
        for ($i = 0; $i < $lengthOfList; $i++) {
            $item = ConstUtil::getContentYml('users', 'user_flg', $i);
            
            switch ($item) {
                case 'admin':
                    $options[] = $checkboxList[0];
                    break;
                case 'user':
                    $options[] = $checkboxList[1];
                    break;
                case 'support':
                    $options[] = $checkboxList[2];
                    break;
            }
        }

        return $options;
    }

    // handle input of add/update to return array of input data
    public function handleInput(Request $request, $method = '')
    {
        $input = $request->all();
        $data = [
            'name' => $input['name'],
            'user_flg' => $input['user_flg'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'date_of_birth' => $input['dateOfBirth'],
        ];
        // Only add new user when method = add
        if ($method == 'add') {
            $data['email'] = $input['email'];
            $data['password'] = Hash::make($input['password']);
            $data['created_by'] = Auth::id();
        }

        return $data;
    }
}