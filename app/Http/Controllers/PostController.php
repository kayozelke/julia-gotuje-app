<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
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
            $posts = Post::with(['createdByUser', 'updatedByUser'])->where('parent_category_id', $parent_category_id)->orderBy('updated_at')->get();
        } else {
            // $posts = Post::where('parent_category_id', null)->orderBy('updated_at')->get();
            $posts = Post::with(['createdByUser', 'updatedByUser'])->orderBy('updated_at')->get();        
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

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'custom_url' => 'required|string|max:255',
            'template_type' => 'required',
            'post_content' => 'required|string',
        ],
        // [
        //     'title.required' => 'Tytuł jest wymagany',
        //     'custom_url.required' => 'Niestandardowy URL jest wymagany',
        //     'template_type.required' => 'Typ szablonu jest wymagany',
        //     'post_content.required' => 'Treść wpisu jest wymagana',
        //     'title.string' => 'Tytuł musi być ciągiem znaków',
        //     'custom_url.string' => 'Niestandardowy URL musi być ciągiem znaków',
        //     'post_content.string' => 'Treść wpisu musi być ciągiem znaków',
        // ]
        );
        
        $parent_category_id = $request->input('parent_category_id');

        // print_r($parent_category_id);
        // echo '<br>-------------<br>';
        // return;

        // check if category exists
        if ($parent_category_id != 0){    
            if (Category::where('id', $parent_category_id)->exists()) {}
            else {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wybrana kategoria (ID: '.$parent_category_id.') nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać inną kategorię.',
                ]);
            }
        } else {
            $parent_category_id = null;
        }


        // handle hiding post
        $hide_before_time_param = null;
        try {
            if($request->input('use_hide_before_time') == "on"){
                // echo 'use_hide_before_time is ON<br> ';
                if ($request->input('hide_before_time') != null) {
                    // echo 'hide_before_time is not not null, value: ' . $request->hide_before_time . '<br>';
                    // convert input, ex. 2025-01-12T18:35 to database time format, ex. like now()
                    $hide_before_time_param = Carbon::parse($request->input('hide_before_time'));
                } 
            } 
        } catch (\Exception $e){
            return redirect()->back()->with([
                'toastErrorTitle' => 'Wystąpił błąd!',
                'toastErrorDescription' => $e->getMessage(),
            ]);
        }

        $is_hidden_param = null;
        if($request->input('is_hidden') == "on"){
            $is_hidden_param = 1;
        } else {
            $is_hidden_param = 0;
        }

        try {
            Post::create([
                'title' => $validated['title'],
                'url' => $validated['custom_url'],
                'template_type' => $validated['template_type'],
                'content' => $validated['post_content'],
                'parent_category_id' => $parent_category_id,
                'is_hidden' => $is_hidden_param,
                'hide_before_time' => $hide_before_time_param,
                'created_at' => now(),
                'created_by' => Auth::id(),
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);

            // return redirect()->back()->with([
            return redirect()->route('admin.posts')->with([
                'toastSuccessTitle' => 'Pomyślnie dodano wpis',
                'toastSuccessHideTime' => 5,
            ]);
            // echo "OK<br>";

        } catch (\Exception $e) {
            // echo "NIE OK<br>";
            // print_r($e->getMessage());

            // return;

            return redirect()->back()->with([
            // return redirect()->route('admin.posts')->with([
                'toastErrorTitle' => 'Wystąpił błąd!',
                'toastErrorDescription' => $e->getMessage(),
                // 'toastErrorHideTime' => 10,
            ]);
        }
        // return;
    }

    public function panelView(Request $request){
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        // $parent_category_id = $request->query('category_id');
        $parent_category_id = null;
        $parent_categories = null;


        $post_id = $request->query('id');

        print_r($post_id);
        return;


        // code for parent categories to modify
        // foreach(array_reverse((new Category())->findParentCategories($c->id)) as $p){
        //     if (! ($c->id == $p->id)){
        //         $c->parent_categories_str .= $p->name . ' / ';
        //     } else {
        //         $c->parent_categories_str .= $p->name;
        //     }
        // }
    }

}

