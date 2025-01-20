<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PostImage;

class ImageController extends Controller
{
    public function panelList(Request $request){

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        if (!$request->has('per_page')) {
            // Redirect to the same page but with set 'per_page'
            return redirect()->route('admin.images', ['per_page' => 5])
            ->with([
                'toastSuccessTitle' => "$toastSuccessTitle",
                'toastSuccessDescription' => "$toastSuccessDescription",
                'toastSuccessHideTime' => $toastSuccessHideTime,
                'toastErrorTitle' => $toastErrorTitle,
                'toastErrorDescription' => $toastErrorDescription,
                'toastErrorHideTime' => $toastErrorHideTime,
            ]);
        }

        $perPage = $request->get('per_page'); // 5 elements by default


        // $parent_category_id = $request->query('category_id');
        // $current_category = null;
        // $subcategories = null;
        
        // $images = Image::all();
        $images = Image::orderBy('created_at', 'desc')->with(
            ['createdByUser', 'updatedByUser']
        )->paginate($perPage);

        return view('panel.auth.images.list', [
            'images' => $images->appends(['per_page' => $perPage]), // Add 'per_page' to pagination links

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelAdd(Request $request) {
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        return view('panel.auth.images.add', [

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }


    public function panelAddPost(Request $request) {
        // Validate files and data
        $request->validate([
            'imageFilesMultiple' => 'required|array', 
            'imageFilesMultiple.*' => 'file|image|max:2048', // max size 2 MB per image
            'titles' => 'array',
            'titles.*' => 'string|max:255',
            'labels' => 'array',
            // 'labels.*' => 'string|max:255',
        ]);

        $images = $request->file('imageFilesMultiple');
        
        if (!$images || !is_array($images)) {
            return redirect()
                ->back()
                ->with([
                    'toastErrorTitle' => 'Wystąpił błąd!',
                    'toastErrorDescription' => 'Musisz przesłać przynajmniej jeden plik.',
                ]);
        }

        $titles = $request->input('titles');
        $labels = $request->input('labels');
        $uploadPath = public_path('uploaded_images'); 

        // Process each file
        foreach ($images as $index => $image) {
            // Create a unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($uploadPath, $filename);

            // Create database entry
            Image::create([
                'file_location' => "/uploaded_images/$filename",
                'title' => $titles[$index] ?? null,
                'label' => $labels[$index] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        // Return feedback
        return redirect()
            ->route('admin.images')
            ->with('toastSuccessTitle', 'Obrazy zostały przesłane!')
            ->with('toastSuccessDescription', 'Wszystkie obrazy zostały poprawnie zapisane.');
    }

    public function panelShow(Request $request) {        
        
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        $image_id = $request->query('id');

        $image = null;

        if (isset($image_id)) {

            if ( !(Image::where('id', $image_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Obraz o ID "' . $image_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny obraz.',
                ]);
            } else {
                $image = Image::with(['createdByUser', 'updatedByUser'])->find($image_id);
            }

        } else {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Niepoprawne ID obrazu: "' . $image_id . '"!',
                // 'toastErrorDescription' => 'Proszę wybrać poprawny wpis.',
            ]);
        }

        return view('panel.auth.images.show', [
            'image' => $image,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelUpdate(Request $request) {

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        $image_id = $request->query('id');

        $image = null;

        if (isset($image_id)) {

            if ( !(Image::where('id', $image_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Obraz o ID "' . $image_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny obraz.',
                ]);
            } else {
                $image = Image::with(['createdByUser', 'updatedByUser'])->find($image_id);
            }

        } else {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Niepoprawne ID obrazu: "' . $image_id . '"!',
                // 'toastErrorDescription' => 'Proszę wybrać poprawny wpis.',
            ]);
        }

        return view('panel.auth.images.update', [
            'image' => $image,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }

    public function panelUpdatePost(Request $request){
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $validated = $request->validate([
            'update_id' => 'required|integer|exists:images,id', // Check if id exists in database
            'title' => 'required|string',   
            'label' => 'nullable|string',          
        ]);

        $image = Image::with(['createdByUser','updatedByUser'])->findOrFail($request->input('update_id'));

        $image->update([
            'title' => $validated['title'],
            'label' => $validated['label'],
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.images.show', ['id' => $image->id])
        // ->with('success', 'Ustawienie zostało zaktualizowane.')
        // ->with('toastSuccessTitle', 'Zaktualizowano pomyślnie!')
        // ->with('toastSuccessHideTime', 5);
        // ->with('toastSuccessDescription', 'Wszystkie obrazy zostały poprawnie zapisane.');
        ->with([
            'toastSuccessTitle' => 'Zaktualizowano pomyślnie!',
            'toastSuccessHideTime' => 5,
        ]);
    }

    // Delete image
    public function panelDelete(Request $request) {
        
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        $image_id = $request->query('id');

        $image = null;

        if (isset($image_id)) {

            if ( !(Image::where('id', $image_id)->exists()) ) {
                return redirect()->back()->with([
                    'toastErrorTitle' => 'Obraz o ID "' . $image_id . '" nie istnieje!',
                    'toastErrorDescription' => 'Proszę wybrać poprawny obraz.',
                ]);
            } else {
                $image = Image::with(['createdByUser', 'updatedByUser'])->find($image_id);
            }

        } else {
            return redirect()->back()->with([
                'toastErrorTitle' => 'Niepoprawne ID obrazu: "' . $image_id . '"!',
                // 'toastErrorDescription' => 'Proszę wybrać poprawny wpis.',
            ]);
        }

        return view('panel.auth.images.delete', [
            'image' => $image,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }
    public function panelDeletePost(Request $request) {
        // Find image by ID

        $image = Image::find($request->delete_id);
        if (!$image) {
            return redirect()->back()->with(['toastErrorTitle' => 'Obraz o ID "' . $request->delete_id . '" nie istnieje.']);
        }

        // if image in PostImage table - abort

        $postImageMatches = PostImage::where('image_id', $image->id)
            ->select('post_id')
            ->get();
        if (count($postImageMatches) > 0) {
            
            return redirect()->back()->with([
                'toastErrorTitle' => 'Nie można usunąć obrazu!',
                'toastErrorDescription' => "Zasób jest wykorzystywany w postach: " . implode(', ', $postImageMatches) ,
            ]);
        }

        $image_path = $image->file_location;
        // Remove first slash from path
        $image_path = substr($image_path, 1);
        // Get full path to image
        $image_path = public_path($image_path);
        

        try {
            // Try to delete image from database
            $image->delete();
            
        } catch (\Exception $e) {
            return redirect(route('admin.images'))->with([
                'toastErrorTitle' => 'Wystąpił błąd podczas usuwania obrazu!',
                // 'toastErrorDescription' => $e->getMessage(),
                // 'toastErrorHideTime' => 10,
            ]);
        }

        try {
            // try to delete image from server
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        } catch (\Exception $e) {
            return redirect(route('admin.images'))->with([
                'toastErrorTitle' => 'Wystąpił błąd podczas usuwania obrazu!',
                // 'toastErrorDescription' => "Dane w bazie zostały usunięte, ale plik na serwerze nie mógł zostać usunięty: " . $e->getMessage(),
            ]);
        }        
        
        return redirect(route('admin.images'))->with([
            'toastSuccessTitle' => 'Pomyślnie usunięto obraz',
            'toastSuccessHideTime' => 5,
        ]);

    }
}
