<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function panelList(Request $request){

        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);


        // $parent_category_id = $request->query('category_id');
        // $current_category = null;
        // $subcategories = null;
        $images = Image::all();

        return view('panel.auth.images.list', [
            'images' => $images,

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
        // dd($request->all(), $request->file('imageFilesMultiple'));



        
        // if($request->hasFile('imageFilesMultiple')) {
        //     $allowedfileExtension=['jpg','png'];
        //     $files = $request->file('imageFilesMultiple');
        //     foreach($files as $file){
        //         $filename = $file->getClientOriginalName();
        //         $extension = $file->getClientOriginalExtension();
        //         $check=in_array($extension,$allowedfileExtension);
        //         // dd($check);
        //         if($check) {
        //             // $items= Item::create($request->all());
        //             foreach ($request->photos as $photo) {
        //                 // $filename = $photo->store('photos');
        //                 // ItemDetail::create([
        //                 // 'item_id' => $items->id,
        //                 // 'filename' => $filename
        //                 // ]);
        //             }
        //             echo "Check Successfully <br>";
        //         }
        //         else {
        //             echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
        //         }
        //     }
        // } else {
        //     echo "no file<br>";
        // }

        // return;




        // Walidacja plików i danych
        $request->validate([
            'imageFilesMultiple' => 'required|array', // Sprawdza, czy to tablica
            'imageFilesMultiple.*' => 'file|image|max:2048', // Maksymalnie 2 MB na obraz
            'titles' => 'array',
            'titles.*' => 'string|max:255',
            'labels' => 'array',
            'labels.*' => 'string|max:255',
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
        $uploadPath = public_path('uploaded_images'); // Katalog na serwerze
    
        // Przetwarzanie każdego pliku
        foreach ($images as $index => $image) {
            // Tworzenie unikalnej nazwy pliku
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($uploadPath, $filename);
    
            // Tworzenie wpisu w bazie danych
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
    
        // Informacja zwrotna
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

        $image = Image::find($request->delete_id);
        if (!$image) {
            return redirect()->back()->with(['toastErrorTitle' => 'Obraz o ID "' . $request->delete_id . '" nie istnieje.']);
        }

        $image_path = $image->file_location;
        // remove first slash from path
        $image_path = substr($image_path, 1);
        // get full path to image
        $image_path = public_path($image_path);

        try {
            // try to delete image from database
            $image->delete();
            
        } catch (\Exception $e) {
            return redirect(route('admin.images'))->with([
                'toastErrorTitle' => 'Wystąpił błąd podczas usuwania obrazu!',
                'toastErrorDescription' => $e->getMessage(),
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
                'toastErrorDescription' => "Dane w bazie zostały usunięte, ale plik na serwerze nie mógł zostać usunięty: " . $e->getMessage(),
            ]);
        }        
        
        return redirect(route('admin.posts'))->with([
            'toastSuccessTitle' => 'Pomyślnie usunięto wpis',
            'toastSuccessHideTime' => 5,
        ]);

    }
}
