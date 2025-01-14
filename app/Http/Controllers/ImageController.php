<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

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
                'file_location' => "uploads/images/$filename",
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
    
    public function panelShow(Request $request) {}
    public function panelDelete(Request $request) {}
    public function panelDeletePost(Request $request) {}
}
