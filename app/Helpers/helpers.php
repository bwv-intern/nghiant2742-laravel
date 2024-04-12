<?php

use App\Services\UserService;
use App\Utils\ConstUtil;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('parseRole')) {
    function parseRole($userFlg)
    {
        return ConstUtil::getContentYml('users','user_flg', $userFlg);
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('isCheckedBox')) {
    function isCheckedBox($userFlg)
    {
        $checkboxValue = UserService::getValueCheckbox();
        if(empty($userFlg)) return $checkboxValue;

        foreach ($checkboxValue as &$checkbox) {
            $checkbox['checked'] = in_array($checkbox['value'], $userFlg);
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
        $userFlg = array();
        for ($i=0; $i < $len; $i++) { 
            array_push($userFlg, ConstUtil::getContentYml('users','user_flg', $i));
        }
        return $userFlg;
    }
}