<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Utils\ConstUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

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

    // Handle input of add/update to return array of input data
    public function handleSaveData(Request $request, $method = '')
    {
        $input = $request->all();
        $data = [
            'email' => $input['email'],
            'name' => $input['name'],
            'user_flg' => $input['user_flg'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'date_of_birth' => $input['date_of_birth'],
        ];

        if (!empty($input['password'])) {
            $data['password'] = Hash::make($input['password']);
        }

        // Only add new user when method = add
        if ($method == 'add') {
            return $this->userRepository->store('users', $data);
        }
        
        // Get user id need to edit
        $id = $input['id'];
        return $this->userRepository->update('users', $id, $data);
    }
}