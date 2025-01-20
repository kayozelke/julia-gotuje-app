<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class DashboardController extends Controller {

    public function dashboardPanel(Request $request){
        
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $publicated_posts = 'N/A';

        // get posts count that are not hidden (is_hidden = 0) and where the value at column hide_before_time is null or time at value is in the past
        try { 
            $publicated_posts = Post::where('is_hidden', 0)
                ->where(function ($query) {
                    $query->whereNull('hide_before_time')
                        ->orWhere('hide_before_time', '<', now());
                })
                ->count();
        } catch (\Exception $e) {
            $publicated_posts = 'N/A';
        }

        
        
        return view('panel.auth.dashboard', [
            'publicated_posts' => $publicated_posts,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }
    

}
