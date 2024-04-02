<?php

use App\Services\UserService;
use App\Utils\ConstUtil;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('parseRole')) {
    function parseRole($user_flg)
    {
        return ConstUtil::getContentYml('users','user_flg', $user_flg);
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('isCheckedBox')) {
    function isCheckedBox($user_flg)
    {
        $checkboxValue = UserService::getValueCheckbox();
        if(empty($user_flg)) return $checkboxValue;

        foreach ($checkboxValue as &$checkbox) {
            $checkbox['checked'] = in_array($checkbox['value'], $user_flg);
        }
        return $checkboxValue;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('getArrayUserFlg')) {
    function getArrayUserFlg()
    {
        $len = ConstUtil::getLengthOfContentYml('users', 'user_flg');
        $user_flg = array();
        for ($i=0; $i < $len; $i++) { 
            array_push($user_flg, ConstUtil::getContentYml('users','user_flg', $i));
        }
        return $user_flg;
    }
}