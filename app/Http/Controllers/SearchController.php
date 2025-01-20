<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    
    public function searchPanel(string $searchText)
    {
        // 
        return ['id1' => 'test1', 'id2' => 'test2'];
    }

    public function apiSearchPanel(Request $request){
        $text = (string)$request->query('search_text');

        // sleep(1);

        return [
            'results' => $this->searchPanel($text),
        ];
    }
}

