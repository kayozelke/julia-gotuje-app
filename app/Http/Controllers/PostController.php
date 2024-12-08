<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
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


        $parent_category_id = $request->query('category_id');
        $subcategories = null;
        $posts = null;

        if(isset($parent_category_id)){
            // $parent_category_id = $request->category_id;

            $category = Category::find($parent_category_id);
            if(!$category){
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wystąpił błąd.',
                    'toastErrorDescription' => 'Kategoria o ID "'.$parent_category_id.'" nie istnieje.',
                ]);
            }
            $posts = Post::where('parent_category_id', $parent_category_id)->orderBy('updated_at')->get();
            echo 'OK - some category set';
        } else {
            $posts = Post::where('parent_category_id', null)->orderBy('updated_at')->get();
            echo 'OK - no category set';
        }


        echo view('panel.auth.header');
        echo "TEST 123<br>";

        $searchQuery = $request->query('search');
        
        echo "<br><hr><br>";
        print_r(compact('searchQuery'));
        echo "<br><hr><br>";
        print_r($searchQuery);
        echo "<br><hr><br>";

        // print_r($request);
        echo view('panel.auth.footer');

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

