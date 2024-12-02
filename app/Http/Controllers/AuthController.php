<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        $user = new User();

        $credentials = $request->only('email', 'password');

        if(auth()->attempt($credentials)){
            echo "dane są ok";
            return;
        }else{
            return redirect()->back()->withErrors([
                'email' => 'Podany email lub hasło są nieprawidłowe'
            ]);
        }

    }

    function index(){
        return view('panel/auth/home_page');
    }
}
