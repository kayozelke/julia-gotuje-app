<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use \App\Models\Post;
use \App\Models\Image;


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

        $results = [];
        foreach ($posts as $post) {            
            // $results[$post->title] = route('admin.posts.show', ['id' => $post->id]);
            array_push($results, [
                'type' => 'post',
                'title' => $post->title,
                'url' => route('admin.posts.show', ['id' => $post->id]),
            ]);
        }
        $images = Image::where('title', 'like', '%'.$searchText.'%')
            ->orWhere('label', 'like', '%'.$searchText.'%')
            ->select('id', 'title')
            ->get();
        foreach ($images as $image) {
            // $results[$image->title] = route('admin.images.show', ['id' => $image->id]);
            array_push($results, [
                'type' => 'image',
                'title' => $image->title,
                'url' => route('admin.images.show', ['id' => $image->id]),
            ]);
        }
        return $results;

        // return ['id1' => 'test1', 'id2' => 'test2'];
    }

    public function apiSearchPanel(Request $request){
        $text = (string)$request->query('search_text');

        // sleep(1);
        $more_items = 0;

        $search_results = $this->searchPanel($text);

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
}