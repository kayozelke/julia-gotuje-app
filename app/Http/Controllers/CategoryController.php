<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // eventually TODO
    // - put toasts includings into header and remove includes at each view
    // - add page titles into session variables

    // ############################## PANEL ##############################

    public function panelList(Request $request)
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

        $category = null;
        $categories = null;
        $parent_category_id = null;

        if (isset($request->id)) {
            $parent_category_id = $request->id;
            $category = Category::find($parent_category_id);

            if (!$category) {
                // echo "Category with ID $param not found.";
                // return;

                return view('panel.auth.header') . view('panel.components.pages_misc_error') . view('panel.auth.footer');
            }

            $categories = Category::where('parent_id', $parent_category_id)->orderBy('id')->get();
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
            'current_category_id' => $parent_category_id,
            'p_category' => $category,
            'categories' => $categories,
            'parent_categories' => (new Category())->findParentCategories($parent_category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelAddPost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // if(isset($request->update_id) && ($request->update_id == $request->parent_category_id)){
        if (isset($request->update_id) && !empty($request->update_id)) {
            $category = Category::find($request->update_id);
            if (!$category) {
                return redirect()->back()->withErrors(['category' => 'Kategoria o ID "' . $request->update_id . '" nie istnieje.']);
            }
            $category->update([
                'name' => $validated['name'],
                // 'parent_id' => $request->parent_category_id,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ]);
            // return redirect()->back()->with([


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

    public function panelUpdate(Request $request)
    {

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $category_id = $request->id;

        $category = Category::find($category_id);
        if (!$category) {
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "' . $category_id . '" nie istnieje.']);
        }
        // $parent_id = $category->parent_id;

        return view('panel.auth.categories.update', [
            'category' => $category,
            'parent_categories' => (new Category())->findParentCategories($category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelDelete(Request $request)
    {

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $category_id = $request->id;
        $category = Category::find($category_id);
        if (!$category) {
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "' . $category_id . '" nie istnieje.']);
        }
        // $parent_id = $category->parent_id;

        return view('panel.auth.categories.delete', [
            'category' => $category,
            'backPage' => url()->previous(),
            'parent_categories' => (new Category())->findParentCategories($category_id),
            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelDeletePost(Request $request)
    {
        $category = Category::find($request->delete_id);
        if (!$category) {
            return redirect()->back()->with(['toastErrorTitle' => 'Kategoria o ID "' . $request->delete_id . '" nie istnieje.']);
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

    // ############################## FRONT ##############################

    public function frontListCategoriesWithParentParam(Request $request)
    {
        $parent_category = null;
        $parent_category_id = null;
        $subcategories = null;

        if (isset($request->id)) {
            $parent_category_id = $request->id;
            $parent_category = Category::find($parent_category_id);

            // If the category does not exist, return a 404 error
            if (!$parent_category) {
                abort(404, 'Category not found');
            }

            // Fetch subcategories for the given parent category
            $subcategories = Category::where('parent_id', $parent_category_id)
                ->orderBy('name')
                ->get();

            foreach ($subcategories as $subcategory) {
                $subcategory->post_count = $this->countItemsAtCategory($subcategory->id);
            }


            // If the parent ID is not null, return the `sub_categories_page` view
            return view('front.sub_categories_page', [
                'parent_category' => $parent_category,
                'subcategories' => $subcategories,
                'recurrent_parent_categories' => (new Category())->findParentCategories($parent_category_id),
            ]);
            
        } else {
            // Fetch top-level categories (categories with no parent)
            $subcategories = Category::whereNull('parent_id')
                ->orderBy('name')
                ->get();

            foreach ($subcategories as $subcategory) {
                $subcategory->post_count = $this->countItemsAtCategory($subcategory->id);
            }

            // If the parent ID is null, return the `main_categories_page` view
            return view('front.main_categories_page', [
                'parent_category' => $parent_category,
                'subcategories' => $subcategories,
                'recurrent_parent_categories' => (new Category())->findParentCategories($parent_category_id),
            ]);
        }
    }

    // public function testKayoz(Request $request){
    //     $category_id = $request->query('id');
    //     print_r($this->countItemsAtCategory($category_id));
    //     print_r("<br>");
    //     return;
    // }

    public function countItemsAtCategory(int $categoryId, bool $with_children = true){
        $count = Post::where('parent_category_id', $categoryId)->count();
        if (!$with_children){
            return $count;
        }

        $children_categories = (new Category())->findChildrenCategories($categoryId);

        foreach($children_categories as $children_category){
            $count += Post::where('parent_category_id', $children_category)->count();
        }
        return $count;

    }
}
