<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use \App\Models\Post;
use \App\Models\Image;


class SearchController extends Controller
{

    private function searchGlobal(string $searchText, bool $groupByType = false)
    {
        // 
        // get list of elements in which $searchText in was found at post title or at post content        
        $posts = Post::where('title', 'like', '%'.$searchText.'%')
            ->orWhere('content', 'like', '%'.$searchText.'%')
            ->select('id', 'title')
            ->get();

        $results = [];
        foreach ($posts as $post) {            
            $item = [
                'type' => 'post',
                'title' => $post->title,
                'url' => route('admin.posts.show', ['id' => $post->id]),
            ];

            if ($groupByType){
                // if not 'posts' in results, create results
                if (!isset($results['posts'])) {
                    $results['posts'] = [];
                }
                
                // add item to results -> posts -> here
                array_push($results['posts'], $item);
            }
            else {
                array_push($results, $item);
            }
        }
        $images = Image::where('title', 'like', '%'.$searchText.'%')
            ->orWhere('label', 'like', '%'.$searchText.'%')
            ->select('id', 'title')
            ->get();
        foreach ($images as $image) {
            $item = [
                'type' => 'image',
                'title' => $image->title,
                'url' => route('admin.images.show', ['id' => $image->id]),
            ];

            if ($groupByType){
                if (!isset($results['images'])) {
                    $results['images'] = [];
                }
                array_push($results['images'], $item);
            }
            else {
                array_push($results, $item);
            }
        }
        return $results;

        // return ['id1' => 'test1', 'id2' => 'test2'];
    }

    public function apiSearchPanel(Request $request){
        $text = (string)$request->query('search_text');

        // sleep(1);
        $more_items = 0;

        $search_results = $this->searchGlobal($text);

        // if search results is more than 5 elements, get first 5 elements and add count of next elements to $more_items
        if (count($search_results) > 5) {
            $more_items = count($search_results) - 5;
            $search_results = array_slice($search_results, 0, 5);
        }

        return [
            'results' => $search_results,
            'more_items' => $more_items
        ];
    }

    // ######### views

    public function panelSearch(Request $request){
        
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        
        $search_query = $request->query('query');

        // if query not set return page back
        if (!isset($search_query) || $search_query == '') {
            return redirect()->back();
        }

        $search_results = $this->searchGlobal($search_query, false);

        print_r($search_results);

        return view('panel.auth.search.results', [
            'search_query' => $search_query,
            'search_results' => $search_results,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);

    }
}