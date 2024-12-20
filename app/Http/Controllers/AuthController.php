<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// use phpDocumentor\Reflection\PseudoTypes\True_;

class AuthController extends Controller
{


    // function index(): View {
    //     return view('panel/auth/home_page');
    // }
    
    //
    public function login(){
        // echo "hello from controller - login";
        if(User::count() == 0){
            $this->addFirstUser();
            return view('panel/unauth/login', ['first_user' => true]);
        } 

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);
        
        
        // echo "There is already ". User::count()." user(s) at database.";

        return view('panel/unauth/login', [
            'first_user' => false,
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function logout(Request $request): RedirectResponse {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login')->with([
            'toastSuccessTitle' => 'Wylogowano!',
            // 'toastSuccessDescription' => 'Proszę wybrać inną nazwę.',
            'toastSuccessHideTime' => 5,
        ]);
    }
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect(route('login'));
    // }

    public function loginPost(Request $request){
        // echo "hello from controller - loginPost";
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = new User();

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            
            return redirect()->intended('admin/home')->with([
                'toastSuccessTitle' => 'Zalogowano!',
                // 'toastSuccessDescription' => 'Proszę wybrać inną nazwę.',
                'toastSuccessHideTime' => 5,
            ]);;
            // return redirect()->intended(route("admin.home"));
        }else{
            return redirect()->back()->withErrors([
                'email' => 'Podany email lub hasło są nieprawidłowe'
            ]);
        }

    }

    private function addFirstUser(){


        // $password = Str::random(15);
        $password = "CHANGETHISPASSWORD";

        $user = new User();
        $user->email = "system@example.com";
        $user->first_name = "System";
        $user->last_name = "Admin";
        $user->password = Hash::make($password);

        if($user->save()){
            return true;
        };

        return false;
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
}
