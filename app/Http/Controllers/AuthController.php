<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(){
        // echo "hello from controller - login";
        return view('panel/unauth/login');
    }

    public function loginPost(Request $request){
        echo "hello from controller - loginPost";
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }

    function index(){
        return view('panel/auth/home_page');
    }
}
