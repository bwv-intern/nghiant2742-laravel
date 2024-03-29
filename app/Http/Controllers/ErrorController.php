<?php

namespace App\Http\Controllers;

use App\Utils\MessageUtil;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Denied permission
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deniedPermission() {
        $errorMsg = MessageUtil::getMessage('E016');
        return view('screens.errors.403', ['errorMsg' => $errorMsg]);
    }

    /**
     * Not Found Page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notFound() {
        $errorMsg = MessageUtil::getMessage('E018');
        return view('screens.errors.404', ['errorMsg' => $errorMsg]);
    }
}
