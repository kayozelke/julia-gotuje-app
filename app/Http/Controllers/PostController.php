<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Image;
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

    // ############################## PANEL ##############################

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
            $posts = Post::with(['createdByUser', 'updatedByUser', 'imagesByPriority'])->where('parent_category_id', $parent_category_id)->orderBy('updated_at')->get();
        } else {
            // $posts = Post::where('parent_category_id', null)->orderBy('updated_at')->get();
            $posts = Post::with(['createdByUser', 'updatedByUser', 'imagesByPriority'])->orderBy('updated_at')->get();        
        }

        // get most prioritized image for every post (post thumbnail)
        foreach ($posts as $post) {
            $post->prioritized_image = $post->imagesByPriority->first();
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

    public function panelUpdate(Request $request){
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $p_category = null;
        $parent_category_id = $request->query('category_id');
        $post_update_id = $request->query('update_id');
        $post_to_update = null;

        $is_new_post = true;

        if(isset($post_update_id)){
            if ( !(Post::where('id', $post_update_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wpis o ID "' . $post_update_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny post.',
                ]);
            } else {
                $post_to_update = Post::with(['createdByUser', 'updatedByUser', 'imagesByPriority'])->find($post_update_id);

                $post_to_update['post_content'] = str_replace('__se__float-left text-start', '__se__float-left', $post_to_update['post_content']);
                $post_to_update['post_content'] = str_replace('__se__float-right text-end', '__se__float-right', $post_to_update['post_content']);
                $post_to_update['post_content'] = str_replace('__se__float-center text-center', '__se__float-center', $post_to_update['post_content']);

                $is_new_post = false;
            }
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


        $all_images = Image::all();



        return view('panel.auth.posts.update', [
            // 'p_category' => $p_category,
            'all_categories' => $all_categories,
            'all_images' => $all_images,
            'post_to_update' => $post_to_update,
            'is_new_post' => $is_new_post,
            'backPage' => url()->previous(),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelUpdatePost(Request $request){

        // debug only
        // echo "selected_images: <br>";
        // print_r($request->input('selected_images'));
        // echo "<hr>";
        // echo "all: <br>";
        // print_r($request->all());
        // return;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'custom_url' => 'required|string|max:255',
            'template_type' => 'required',
            // 'post_content' => 'required|string',
            'post_content' => 'nullable|string',
            ],
            [
                'title.required' => 'Tytuł jest wymagany',
                'custom_url.required' => 'Adres URL jest wymagany',
                'template_type.required' => 'Typ wpisu jest wymagany',
                // 'post_content.required' => 'Treść wpisu jest wymagana',
                'title.string' => 'Tytuł musi być ciągiem znaków',
                'custom_url.string' => 'Adres URL musi być ciągiem znaków',
                'post_content.string' => 'Treść wpisu musi być ciągiem znaków',
            ]
        );

        // handle image justifying by sun editor
        // replace strings at post_content: "__se__float-left" to "__se__float-left text-start"
        // replace strings at post_content: "__se__float-right" to "__se__float-right text-end"
        // replace strings at post_content: "__se__float-center" to "__se__float-center text-center"
        $validated['post_content'] = str_replace('__se__float-left', '__se__float-left text-start', $validated['post_content']);
        $validated['post_content'] = str_replace('__se__float-right', '__se__float-right text-end', $validated['post_content']);
        $validated['post_content'] = str_replace('__se__float-center', '__se__float-center text-center', $validated['post_content']);

        
        $parent_category_id = $request->input('parent_category_id');

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

        // handle post images
        $selectedImageIds = [];

        if($request->input('selected_images') != null){
            // split string by comma
            $selectedImageIds = explode(',', $request->input('selected_images'));

            // // delete all post images that are not in selectedImageIds array
            // PostImage::where('post_id', $request->input('update_id'))
            //     ->whereNotIn('image_id', $selectedImageIds)
            //     ->delete();

            // // update priority of existing post images
            // foreach ($selectedImageIds as $imageId) {
            //     $priority = $request->input('priority')[$imageId] ?? 1; // Get priority, default to 1 if not set
            //     PostImage::where('post_id', $request->input('update_id'))
            //         ->where('image_id', $imageId)
            //         ->update(['priority' => $priority]);
            // }

            // // add new post images from selectedImageIds array
            // foreach ($selectedImageIds as $imageId) {
            //     // check if image exists
            //     if (Image::where('id', $imageId)->exists()) {
            //         // check if post image already exists
            //         if (!PostImage::where('post_id', $request->input('update_id'))->where('image_id', $imageId)->exists()) {
            //             // add new post image
            //             PostImage::create([
            //                 'post_id' => $request->input('update_id'),
            //                 'image_id' => $imageId,
            //                 'priority' => $request->input('priority')[$imageId] ?? 1, // Set default priority to 1 if not provided
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //                 'updated_by' => Auth::id(),
            //             ]);
            //         }
            //     }
            // }

        }
        


        // check if to update or to add new post
        if ($request->input('update_id') != null){
            if ( !(Post::where('id', $request->input('update_id'))->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wystąpił błąd!',
                    'toastErrorDescription' => 'Wpis o ID "' . $request->input('update_id') . '" nie istnieje!',
                ]);
            } else {
                $post_to_update = Post::with(['createdByUser', 'updatedByUser'])->find($request->input('update_id'));

                // update existing post
                try {
                    $post_to_update->title = $validated['title'];
                    $post_to_update->url = $validated['custom_url'];
                    $post_to_update->template_type = $validated['template_type'];
                    $post_to_update->content = $validated['post_content'];
                    $post_to_update->parent_category_id = $parent_category_id;
                    $post_to_update->is_hidden = $is_hidden_param;
                    $post_to_update->hide_before_time = $hide_before_time_param;
                    $post_to_update->updated_at = now();
                    $post_to_update->updated_by = Auth::id();
    
                    $post_to_update->save();
        
                    
                } catch (\Exception $e) {
                    return redirect()->back()->with([
                        'toastErrorTitle' => 'Wystąpił błąd!',
                        'toastErrorDescription' => $e->getMessage(),
                    ]);
                }
                // handle post images
                try {
                    // delete all post images that are not in selectedImageIds array
                    PostImage::where('post_id', $request->input('update_id'))
                    ->whereNotIn('image_id', $selectedImageIds)
                    ->delete();

                    // update priority of existing post images
                    foreach ($selectedImageIds as $imageId) {
                        $priority = $request->input('priority')[$imageId] ?? 1; // Get priority, if not set then 1
                        $updated = PostImage::where('post_id', $request->input('update_id'))
                            ->where('image_id', $imageId)
                            ->update(['priority' => $priority]);
                    
                        if ($updated) { // if update succeeded
                            $selectedImageIds = array_diff($selectedImageIds, [$imageId]); // Delete $imageId from array $selectedImageIds
                        }
                    }

                } catch (\Exception $e){
                    return redirect()->back()->with([
                        'toastErrorTitle' => 'Wystąpił błąd!',
                        'toastErrorDescription' => $e->getMessage(),
                    ]);
                }

            }
        } else {
            // add new post
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
    
                // return redirect()->route('admin.posts')->with([
                //     'toastSuccessTitle' => 'Pomyślnie dodano wpis',
                //     'toastSuccessHideTime' => 5,
                // ]);
    
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wystąpił błąd!',
                    'toastErrorDescription' => $e->getMessage(),
                ]);
            }
        }

        try {
            // add new post images from selectedImageIds array
            foreach ($selectedImageIds as $imageId) {
                // check if image exists
                if (Image::where('id', $imageId)->exists()) {
                    // add new post image
                    // no need to check if to update, because update was already realized and selectedImageIds contains only elements to add as new at this point
                    PostImage::create([
                        'post_id' => $request->input('update_id'),
                        'image_id' => $imageId,
                        'priority' => $request->input('priority')[$imageId] ?? 1, // Set default priority to 1 if not provided
                        'created_at' => now(),
                        'updated_at' => now(),
                        'updated_by' => Auth::id(),
                    ]);
                } else {
                    return redirect()->back()->with([
                        'toastErrorTitle' => 'Wystąpił błąd!',
                        'toastErrorDescription' => "Obraz o ID '" . $imageId . "' nie istnieje.",
                    ]);
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Wystąpił błąd!',
                'toastErrorDescription' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('admin.posts.show', ['id' => $post_to_update->id])
            ->with([
            'toastSuccessTitle' => 'Zapisano pomyślnie!',
            'toastSuccessHideTime' => 5,
        ]);

    
    }

    public function panelShow(Request $request){
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

        $post = null;

        if (isset($post_id)) {

            if ( !(Post::where('id', $post_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wpis o ID "' . $post_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny post.',
                ]);
            } else {
                $post = Post::with(['createdByUser', 'updatedByUser'])->find($post_id);
            }

        } else {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Niepoprawne ID wpisu: "' . $post_id . '"!',
                // 'toastErrorDescription' => 'Proszę wybrać poprawny wpis.',
            ]);
        }

        $post_images = PostImage::where('post_id', $post_id)
            ->with(['image', 'updatedByUser'])
            ->orderBy('priority', 'desc')->get();



        return view('panel.auth.posts.show', [
            // 'p_category' => $current_category,
            // 'subcategories' => $subcategories,
            'post' => $post,
            'post_images' => $post_images,
            // 'all_categories' => $all_categories,
            // 'recurrent_parent_categories
            'parent_categories' => (new Category())->findParentCategories($post->parent_category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelDelete(Request $request){
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

        $post = null;

        if (isset($post_id)) {

            if ( !(Post::where('id', $post_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Wpis o ID "' . $post_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny post.',
                ]);
            } else {
                $post = Post::with(['createdByUser', 'updatedByUser'])->find($post_id);
            }

        } else {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Niepoprawne ID wpisu: "' . $post_id . '"!',
                // 'toastErrorDescription' => 'Proszę wybrać poprawny wpis.',
            ]);
        }



        return view('panel.auth.posts.delete', [
            'post' => $post,
            'backPage' => url()->previous(),
            'parent_categories' => (new Category())->findParentCategories($post->parent_category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    
    public function panelDeletePost(Request $request){

        $post = Post::find($request->delete_id);
        if (!$post) {
            return redirect()->back()->with(['toastErrorTitle' => 'Wpis o ID "' . $request->delete_id . '" nie istnieje.']);
        }

        try {
            $post->delete();
            return redirect(route('admin.posts'))->with([
                'toastSuccessTitle' => 'Pomyślnie usunięto wpis',
                'toastSuccessHideTime' => 5,
            ]);
        } catch (\Exception $e) {
            return redirect(route('admin.posts'))->with([
                'toastErrorTitle' => 'Wystąpił błąd podczas usuwania wpisu!',
                'toastErrorDescription' => $e->getMessage(),
                // 'toastErrorHideTime' => 10,
            ]);
        }

        
    }


// ############################## FRONT ##############################


    public function show(Request $request){

        // echo 'Youre at show method of PostController.php';
        $custom_url = $request->route('custom_url');
        // echo '<br>';
        // echo 'Custom URL: ' . $custom_url;

        
        $post = Post::with(['createdByUser', 'updatedByUser', 'parent_category'])->where('url', $custom_url)->first();
        

        // If the category does not exist, return a 404 error
        if (!$post) {
            abort(404, 'Page not found: "'.$custom_url.'".');
        }

        // print_r($post);

        // Pobierz ID nadrzędnej kategorii z posta
        $parent_category_id = $post->parent_category_id;

        // Znajdź wszystkie nadrzędne kategorie
        $recurrent_parent_categories = (new Category())->findParentCategories($parent_category_id);

        return view('front.posts.show', [
            // 'parent_category' => $parent_category,
            // 'subcategories' => $subcategories,
            'recurrent_parent_categories' => $recurrent_parent_categories,
            'post' => $post,
        ]);
    }

}

