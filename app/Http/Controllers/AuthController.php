<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(){
        // echo "hello from controller - login";

        if(User::count() == 0){
            echo "omg - first user";
            return view('panel/unauth/login', ['first_user' => true]);
        } 
        
        
        echo "There is already ". User::count()." user(s) at database.";

        return view('panel/unauth/login', ['first_user' => false]);
    }

    public function loginPost(Request $request){
        echo "hello from controller - loginPost";
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = new User();

        $credentials = $request->only('email', 'password');

        // if(auth()->attempt($credentials)){
        //     echo "dane są ok";
        //     return;
        // }else{
        //     return redirect()->back()->withErrors([
        //         'email' => 'Podany email lub hasło są nieprawidłowe'
        //     ]);
        // }

    }

    // // if register was there...
    // function registerPost(Request $request){
    //     $request->validate([
    //         'email' => 'required|email',
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'password' => 'required|min:6',
    //         'password_confirmation' => 'required|same:password',
    //     ]);

    //     $user = new User();
    //     $user->email = $request->email;
    //     $user->first_name = $request->first_name;
    //     $user->last_name = $request->last_name;
    //     $user->password = Hash::make($request->password);

    //     if($user->save()){
    //         return redirect(route("login"))
    //             ->with("success", "User has been created successfully.");
    //     };

    //     return redirect(route("register"))
    //         ->with("error", "Failed to create user account.");
    // }

    function index(){
        return view('panel/auth/home_page');
    }
}
