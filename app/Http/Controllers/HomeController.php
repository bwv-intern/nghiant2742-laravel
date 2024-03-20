<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    
    public function index2() {
        return view('home2');
    }
    
    public function handle(Request $request) {
        $req = $request->validate([
            'name' => 'required|min:5|max:25',
            'age' => 'required|numeric',
            'date' => 'required|date',
            'email' => 'required|email|regex:/^([a-zA-Z0-9_.+-])+@gmail\.com$/',
            'url' => 'required|url',
            'hiragana' => 'required|regex:/^[ぁ-ん]+$/',
            'katakana' => 'required|regex:/^[ァ-ン]+$/',
            'kanji' => 'required|regex:/^[一-龥]+$/',
        ]);

        dd($req);
    }
}
