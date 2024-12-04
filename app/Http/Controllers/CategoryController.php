<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Metoda do wyświetlania wszystkich kategorii
    public function index($param = null)
    {
        // // Pobierz wszystkie kategorie z bazy danych
        // $categories = Category::all();

        // $no_children_categories = false;

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);

        // Znajdź kategorie bez rodzica (parent_id = NULL)
        if (isset($param)) {
            $categories = Category::where('parent_id', $param)->get();
        } else {
            $categories = Category::whereNull('parent_id')->get();
            // if($categories->count() == 0){
            //     $no_children_categories = true;
            // }

        }


        // // Proste wyświetlenie wyników
        // foreach ($categories as $category) {
        //     echo "$category <br>";
        //     // echo "ID: " . $category->id . ", Name: " . $category->name . "<br>";
        // }

        return view('panel.auth.categories', [
            'current_category_id' => $param,
            'categories' => $categories,
            'parent_categories' => $this->findParentCategories($param),
            'toastSuccessTitle' => "Test",
            'toastSuccessDescription' => "Opis test",
            'toastSuccessHideTime' => 5,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
        ]);
    }

    public function addPost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // TODO - handle validation
        if (Category::where('name', $validated['name'])->where('parent_id', $request->parent_category_id)->exists()) {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Kategoria o takiej nazwie już istnieje!',
                'toastErrorDescription' => 'Proszę wybrać inną nazwę.',
                'toastErrorHideTime' => 5
            ]);
        }

        Category::create([
            'name' => $validated['name'],
            'parent_id' => $request->parent_category_id,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);


        return redirect()->route('admin.categories', $request->parent_category_id);
        // $this->printParentCategories($request->parent_category_id);
    }


    /**
     * Recursively finds all parent categories for a given category ID.
     *
     * @param int $categoryId The ID of the category to find parents for.
     * @param array $parents An array to store the parent categories (passed by reference).
     * @return array An array of parent categories, including the initial category.
     */
    private function findParentCategories($categoryId, array &$parents = []): array
    {
        if ($categoryId === null) {
            return $parents;
        }

        $category = Category::find($categoryId);

        if ($category) {
            $parents[] = $category;
            if ($category->parent_id !== null) {
                $this->findParentCategories($category->parent_id, $parents);
            }
        }

        return $parents;
    }
    /**
     * Prints parent categories in a nested, user-friendly format.
     *
     * @param int $categoryId The ID of the category to start from.
     * @return string The nested string representation of parent categories.
     */
    public function printParentCategories($categoryId): string
    {
        $parents = $this->findParentCategories($categoryId);
        if (empty($parents)) {
            return "No parent categories found.";
        }

        $output = "";
        $this->printNestedCategories($parents, 0, $output);
        return $output;
    }

    private function printNestedCategories(array $categories, int $level, string &$output): void
    {
        foreach ($categories as $category) {
            $indent = str_repeat("--", $level);
            $output .= "$indent $category->name\n";
            if ($category->parent_id !== null) {
                $children = Category::where('parent_id', $category->id)->get();
                if ($children->isNotEmpty()) {
                    $this->printNestedCategories($children->toArray(), $level + 1, $output);
                }
            }
        }
    }
}
