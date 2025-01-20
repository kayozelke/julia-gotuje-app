<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use \App\Models\Post;
use \App\Models\Image;
use DB;


class SearchController extends Controller
{
    
    public function searchPanel(string $searchText)
    {
        // 
        // get list of elements in which $searchText in was found at post title or at post content        
        $results = [];

        // Wyszukiwanie postów z dopasowaniem
        $posts = Post::select('id', 'title', DB::raw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE) AS relevance"))
            ->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$searchText, $searchText])
            ->orderByDesc('relevance')
            ->get();
    
        foreach ($posts as $post) {
            $results[] = [
                'type' => 'post',
                'title' => $post->title,
                'url' => route('admin.posts.show', ['id' => $post->id]),
                'relevance' => $post->relevance,
            ];
        }
    
        // Wyszukiwanie obrazów z dopasowaniem
        $images = Image::select('id', 'title', DB::raw("MATCH(title, label) AGAINST(? IN BOOLEAN MODE) AS relevance"))
            ->whereRaw("MATCH(title, label) AGAINST(? IN BOOLEAN MODE)", [$searchText, $searchText])
            ->orderByDesc('relevance')
            ->get();
    
        foreach ($images as $image) {
            $results[] = [
                'type' => 'image',
                'title' => $image->title,
                'url' => route('admin.images.show', ['id' => $image->id]),
                'relevance' => $image->relevance,
            ];
        }
    
        // Sortowanie wyników (opcjonalne, jeśli wyniki różnych typów muszą być wspólnie uporządkowane)
        usort($results, function ($a, $b) {
            return $b['relevance'] <=> $a['relevance'];
        });
    
        return $results;

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

