<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function panelList($request = null){
        echo view('panel.auth.header');
        echo "TEST 123";
        echo view('panel.auth.footer');
    }
}

