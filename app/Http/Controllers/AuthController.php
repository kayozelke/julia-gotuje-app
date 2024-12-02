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

    function index(){
        return view('panel/auth/home_page');
    }
}
