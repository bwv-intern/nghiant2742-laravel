<?php

namespace App\Services;

use App\Utils\ConstUtil;
use App\Utils\MessageUtil;
use DebugBar\DebugBar;
use Maatwebsite\Excel\Facades\Excel;

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

    public static function handleImport($file) {

        $rows = Excel::toCollection([], $file);
        
        $data = $rows->first();

        // Verify header
        $expectedHeader = ["User ID", "Email", "Password", "User Flag", "Date Of Birth", "Name"];
        $header = $data->first()->toArray();


        if ($header !== $expectedHeader) {
            return [
                'error' => true,
                'msg' => MessageUtil::getMessage('errors', 'E008')
            ];
        }

       $lengthData = count($rows->first()->toArray());

        if ($lengthData <= 1) {
            return [
                'error' => true,
                'msg' => 'Your file is empty'
            ];
        }

        return [
            'error' => false,
            'msg' => "File ok"
        ];
    }
}