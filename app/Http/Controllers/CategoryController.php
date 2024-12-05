<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Metoda do wyświetlania wszystkich kategorii
    public function adminCategories($param = null)
    {
        // // Pobierz wszystkie kategorie z bazy danych
        // $categories = Category::all();

        // $no_children_categories = false;

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        // Znajdź kategorie bez rodzica (parent_id = NULL)
        if (isset($param)) {
            $categories = Category::where('parent_id', $param)->orderBy('id')->get();
        } else {
            $categories = Category::whereNull('parent_id')->orderBy('id')->get();
            // if($categories->count() == 0){
            //     $no_children_categories = true;
            // }

        }


        // // Proste wyświetlenie wyników
        // foreach ($categories as $category) {
        //     echo "$category <br>";
        //     // echo "ID: " . $category->id . ", Name: " . $category->name . "<br>";
        // }

        return view('panel.auth.categories.list', [
            'current_category_id' => $param,
            'categories' => $categories,
            'parent_categories' => $this->findParentCategories($param),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function addPost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // if(isset($request->update_id) && ($request->update_id == $request->parent_category_id)){
        if(isset($request->update_id) && !empty($request->update_id)){
            $category = Category::find($request->update_id);
            if (!$category) {
                return redirect()->back()->withErrors(['category' => 'Kategoria o ID "'.$request->update_id.'" nie istnieje.']);
            }
            $category->update([
                'name' => $validated['name'],
                // 'parent_id' => $request->parent_category_id,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);
            // return redirect()->back()->with([
            return redirect(route('admin.categories'))->with([
                'param' => $request->parent_id,
                'toastSuccessTitle' => 'Pomyślnie zaktualizowano kategorię',
                'toastSuccessHideTime' => 5,
            ]);
        }


        // TODO - handle validation
        if (Category::where('name', $validated['name'])->where('parent_id', $request->parent_category_id)->exists()) {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Kategoria o takiej nazwie już istnieje!',
                'toastErrorDescription' => 'Proszę wybrać inną nazwę.',
            ]);
        }

        Category::create([
            'name' => $validated['name'],
            'parent_id' => $request->parent_category_id,
            'created_at' => now(),
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);
        
        return redirect()->back()->with([
            'toastSuccessTitle' => 'Pomyślnie dodano kategorię',
            // 'toastSuccessDescription' => 'Proszę wybrać inną nazwę.',
            'toastSuccessHideTime' => 5,
        ]);

        // return redirect()->route('admin.categories', $request->parent_category_id);
        // $this->printParentCategories($request->parent_category_id);
    }

    public function update($param = null)
    {

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $category = Category::find($param);
        if (!$category) {
            return redirect()->back()->withErrors(['category' => 'Kategoria o ID "'.$param.'" nie istnieje.']);
        }
        // $parent_id = $category->parent_id;

        return view('panel.auth.categories.update', [
            'category' => $category,
            // 'parent_categories' => $this->findParentCategories($param),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
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

    // /**
    //  * Prints parent categories in a nested, user-friendly format.
    //  *
    //  * @param int $categoryId The ID of the category to start from.
    //  * @return string The nested string representation of parent categories.
    //  */
    // public function printParentCategories($categoryId): string
    // {
    //     $parents = $this->findParentCategories($categoryId);
    //     if (empty($parents)) {
    //         return "No parent categories found.";
    //     }

    //     $output = "";
    //     $this->printNestedCategories($parents, 0, $output);
    //     return $output;
    // }

    // private function printNestedCategories(array $categories, int $level, string &$output): void
    // {
    //     foreach ($categories as $category) {
    //         $indent = str_repeat("--", $level);
    //         $output .= "$indent $category->name\n";
    //         if ($category->parent_id !== null) {
    //             $children = Category::where('parent_id', $category->id)->get();
    //             if ($children->isNotEmpty()) {
    //                 $this->printNestedCategories($children->toArray(), $level + 1, $output);
    //             }
    //         }
    //     }
    // }
}
