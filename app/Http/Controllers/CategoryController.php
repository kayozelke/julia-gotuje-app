<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // eventually TODO
    // - put toasts includings into header and remove includes at each view
    // - add page titles into session variables

    public function list($param = null)
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
        $category = null;
        $categories = null;

        if (isset($param)) {
            $category = Category::find($param);
        if (!$category) {
            // echo "Category with ID $param not found.";
            // return;

            return view('panel.auth.header').view('panel.components.pages_misc_error').view('panel.auth.footer');
        }

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
            'p_category' => $category,
            'categories' => $categories,
            'parent_categories' => (new Category())->findParentCategories($param),
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


            // route at web.php looks like below            
            // Route::get('/admin/categories/{param?}', [CategoryController::class, 'list'])->middleware('auth')->name('admin.categories');
            // 

            return redirect()->back()->with([
            // return redirect(route('admin.categories', $request->parent_category_id))->with([
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
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "'.$param.'" nie istnieje.']);
        }
        // $parent_id = $category->parent_id;

        return view('panel.auth.categories.update', [
            'category' => $category,
            'parent_categories' => (new Category())->findParentCategories($param),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function delete($param = null)
    {

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $category = Category::find($param);
        if (!$category) {
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "'.$param.'" nie istnieje.']);
        }
        // $parent_id = $category->parent_id;

        return view('panel.auth.categories.delete', [
            'category' => $category,
            'backPage' => url()->previous(),
            'parent_categories' => (new Category())->findParentCategories($param),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function deletePost(Request $request)
    {
        $category = Category::find($request->delete_id);
        if (!$category) {
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "'.$request->delete_id.'" nie istnieje.']);
        }
        $parent_id = $category->parent_id;

        try {
            $category->delete();
            return redirect(route('admin.categories', $parent_id))->with([
                'toastSuccessTitle' => 'Pomyślnie usunięto kategorię',
                'toastSuccessHideTime' => 5,
            ]);
        } catch (\Exception $e) {
            return redirect(route('admin.categories', $parent_id))->with([
                'toastErrorTitle' => 'Wystąpił błąd podczas usuwania kategorii!',
                'toastErrorDescription' => $e->getMessage(),
                // 'toastErrorHideTime' => 10,
            ]);
        }

    }


    // /**
    //  * Recursively finds all parent categories for a given category ID.
    //  *
    //  * @param int $categoryId The ID of the category to find parents for.
    //  * @param array $parents An array to store the parent categories (passed by reference).
    //  * @return array An array of parent categories, including the initial category.
    //  */
    // private function findParentCategories($categoryId, array &$parents = []): array
    // {
    //     if ($categoryId === null) {
    //         return $parents;
    //     }

    //     $category = Category::find($categoryId);

    //     if ($category) {
    //         $parents[] = $category;
    //         if ($category->parent_id !== null) {
    //             $this->findParentCategories($category->parent_id, $parents);
    //         }
    //     }

    //     return $parents;
    // }

}
