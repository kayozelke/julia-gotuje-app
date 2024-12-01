<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function show(string $id) : View
    {
        
        return view('panel.auth.account_settings', [
            // 'user' => User::findOrFail($id)
            'var_test' => "this text come from value of variable :)",
        ]);

        // return view('panel/auth/account_settings');
    }
}

