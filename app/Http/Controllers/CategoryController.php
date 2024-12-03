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
            'parent_categories' => $this->findParentCategories($param),
        ]);
    }

    /**
     * Recursively finds all parent categories for a given category ID.
     *
     * @param int $categoryId The ID of the category to find parents for.
     * @param array $parents An array to store the parent categories (passed by reference).
     * @return array An array of parent categories, including the initial category.
     */
    private function findParentCategories(int $categoryId, array &$parents = []): array
    {
        $category = Category::find($categoryId);

        if ($category) {
            $parents[] = $category;
            if ($category->parent_id) {
                $this->findParentCategories($category->parent_id, $parents);
            }
        }

        return $parents;
    }

}
