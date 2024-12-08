<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function panelList(Request $request){

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        // echo view('panel.auth.header');
        echo "TEST 123<br>";

        print_r($request);
        // echo view('panel.auth.footer');

        // return view('panel.auth.categories.list', [
        //     'current_category_id' => $param,
        //     'p_category' => $category,
        //     'categories' => $categories,
        //     'parent_categories' => (new Category())->findParentCategories($param),
        //     'toastSuccessTitle' => "$toastSuccessTitle",
        //     'toastSuccessDescription' => "$toastSuccessDescription",
        //     'toastSuccessHideTime' => $toastSuccessHideTime,
        //     'toastErrorTitle' => $toastErrorTitle,
        //     'toastErrorDescription' => $toastErrorDescription,
        //     'toastErrorHideTime' => $toastErrorHideTime,
        // ]);
    }
}

