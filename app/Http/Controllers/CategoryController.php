<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Metoda do wyświetlania wszystkich kategorii
    public function index($param = null)
    {
        // // Pobierz wszystkie kategorie z bazy danych
        // $categories = Category::all();

        // $no_children_categories = false;
        
        // Znajdź kategorie bez rodzica (parent_id = NULL)
        if(isset($param)) {
            $categories = Category::where('parent_id', $param)->get();
        } else {
            $categories = Category::whereNull('parent_id')->get();
            // if($categories->count() == 0){
            //     $no_children_categories = true;
            // }

        }


        // Proste wyświetlenie wyników
        foreach ($categories as $category) {
            echo "$category <br>";
            // echo "ID: " . $category->id . ", Name: " . $category->name . "<br>";
        }

        return view('panel.auth.categories', [
            'categories' => $categories,
            // 'no_children_categories' => $no_children_categories,
        ]);
    }
}
