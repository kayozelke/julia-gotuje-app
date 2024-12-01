<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function show(string $id)
    {
        // return view('user.profile', [
        //     // 'user' => User::findOrFail($id)
        // ]);

        echo view('panel/auth/header');
        echo view('panel/auth/account_settings');
        echo view('panel/auth/footer');
        return;
    }
}

