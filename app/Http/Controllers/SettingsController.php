<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller {

    public function panelList(Request $request){
        return view('panel.auth.settings.list');
    }
    
    public function panelUpdate(Request $request){
        return view('panel.auth.settings.update');
    }

}