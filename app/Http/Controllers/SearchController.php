<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use \App\Models\Post;


class SearchController extends Controller
{
    
    public function searchPanel(string $searchText)
    {
        // 
        // get list of elements in which $searchText in was found at post title or at post content        
        $posts = Post::where('title', 'like', '%'.$searchText.'%')
            ->orWhere('content', 'like', '%'.$searchText.'%')
            ->select('id', 'title')
            ->get();

        $result = [];
        foreach ($posts as $post) {
            $result[$post->id] = $post->title;
        }
        return $result;

        // return ['id1' => 'test1', 'id2' => 'test2'];
    }

    public function apiSearchPanel(Request $request){
        $text = (string)$request->query('search_text');

        // sleep(1);

        $search_results = $this->searchPanel($text);

        return [
            'results' => $search_results,
        ];
    }
}

