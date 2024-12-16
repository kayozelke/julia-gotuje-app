<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function generatePageUrl(string $text){
        // string $text is just a regular text with spaces and letter cases

        // this function should:
        // 1. replace all spaces with char '-'
        // 2. make all leters lowercase
        // 3. replace all polish chars to english ones
        // 4. delete all non letter or non number chars from text

        // return another string as result        
        $text = preg_replace('/\s+/', '-', $text);
        $text = strtolower($text);
        $text = preg_replace("/ó/", "o", $text);
        $text = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text);
        $text = preg_replace('/[^a-zA-Z0-9-]/', '', $text);
        return $text;
    }

    public function apiGeneratePageUrl(Request $request){
        $text = (string)$request->query('text');

        return [
            'page_url' => $this->generatePageUrl($text),
        ];
    }


    public function panelList(Request $request){

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        $parent_category_id = $request->query('category_id');
        $current_category = null;
        $subcategories = null;
        $posts = null;

        if(isset($parent_category_id)){
            $current_category = Category::find($parent_category_id);
            if(!$current_category){
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wystąpił błąd.',
                    'toastErrorDescription' => 'Kategoria o ID "'.$parent_category_id.'" nie istnieje.',
                ]);
            }
            $posts = Post::where('parent_category_id', $parent_category_id)->orderBy('updated_at')->get();
        } else {
            // $posts = Post::where('parent_category_id', null)->orderBy('updated_at')->get();
            $posts = Post::orderBy('updated_at')->get();        
        }

        $all_categories = Category::all();
        foreach($all_categories as $c){
            $c->parent_categories_str = '';
            
            foreach(array_reverse((new Category())->findParentCategories($c->id)) as $p){
                if (! ($c->id == $p->id)){
                    $c->parent_categories_str .= $p->name . ' / ';
                } else {
                    $c->parent_categories_str .= $p->name;
                }
            }
            

            // $c->parent_categories = (new Category())->findParentCategories($c->id);
        }



        $all_categories = $all_categories->sortBy('parent_categories_str');

        $all_categories = $all_categories->toArray();

        array_unshift($all_categories, [
            'id' => "",
            'name' => 'Wszystko',
            'parent_categories_str' => 'Wszystko'
        ]);

        // print_r($all_categories);


        return view('panel.auth.posts.list', [
            'p_category' => $current_category,
            'subcategories' => $subcategories,
            'posts' => $posts,
            'all_categories' => $all_categories,
            // 'recurrent_parent_categories
            'parent_categories' => (new Category())->findParentCategories($parent_category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelAdd(Request $request){
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $p_category = null;
        $parent_category_id = $request->query('category_id');

        // $p_category = ['id' => '', 'name' => 'Wszystko'];
        if(isset($parent_category_id)){
            $p_category = Category::find($parent_category_id);
        }


        $all_categories = Category::all();
        foreach($all_categories as $c){
            $c->parent_categories_str = '';
            
            foreach(array_reverse((new Category())->findParentCategories($c->id)) as $p){
                if (! ($c->id == $p->id)){
                    $c->parent_categories_str .= $p->name . ' / ';
                } else {
                    $c->parent_categories_str .= $p->name;
                }
            }
        }

        $all_categories = $all_categories->sortBy('parent_categories_str');
        $all_categories = $all_categories->toArray();

        // array_unshift($all_categories, [
        //     'id' => "",
        //     'name' => 'Brak',
        //     'parent_categories_str' => 'Brak'
        // ]);




        return view('panel.auth.posts.add', [
            'p_category' => $p_category,
            'all_categories' => $all_categories,
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelAddPost(Request $request){

        print_r("hello");

        // $request->query()
        
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'custom-url' => 'required|string|max:255',
        //     // 'template_type' => 'required',
        // ]);

        // check if category exists
        // if isset ...
        // if (Category::where('parent_id', $request->parent_category_id)->exists()) {
        //     return redirect()->back()->with([
        //         'toastErrorTitle' => 'Kategoria o takiej nazwie już istnieje!',
        //         'toastErrorDescription' => 'Proszę wybrać inną nazwę.',
        //     ]);
        // }

        try {

            Post::create([
                // 'title' => $validated['title'],
                'title' => $request->query('title'),
                // 'custom_url' => $this->generatePageUrl($validated['custom-url']),
                'custom_url' => $request->query('custom-url'),
                // 'template_type' => $validated['template_type'],
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'content' => '',
                'is_hidden' => 0,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('admin.posts')->with([
                'toastSuccessTitle' => 'Pomyślnie dodano wpis',
                'toastSuccessHideTime' => 5,
            ]);
            echo "OK<br>";

        } catch (\Exception $e) {
            // return redirect()->back()->with([
            echo "NIE OK<br>";
            print_r($e->getMessage());
            return redirect()->route('admin.posts')->with([
                'toastErrorTitle' => 'Wystąpił błąd!',
                'toastErrorDescription' => $e->getMessage(),
                // 'toastErrorHideTime' => 10,
            ]);
        }
        // return;
    }

}

