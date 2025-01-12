<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller {

    public function panelList(Request $request){
        // Pobierz wszystkie ustawienia z bazy
        $settings = GeneralSetting::with(['updatedByUser'])->get();

        // Wyślij ustawienia do widoku
        return view('panel.auth.settings.list', ['settings' => $settings]);
    }
    
    public function panelUpdate(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'id' => 'required|integer|exists:general_settings,id', // Sprawdź, czy ID istnieje w bazie
            'value' => 'required|string',          // Wartość musi być wypełniona
            'description' => 'required|string',   // Opis musi być wypełniony
        ]);

        // Pobierz wpis na podstawie ID z żądania
        $setting = GeneralSetting::with(['updatedByUser'])->findOrFail($request->input('id'));

        // Aktualizacja wartości oraz osoby aktualizującej
        $setting->value = $request->input('value');
        $setting->description = $request->input('description'); // Zaktualizuj opis
        $setting->updated_by = Auth::id();                  // Ustaw aktualnego użytkownika jako edytującego
        $setting->updated_at = now();                       // Zapisz aktualną datę i czas

        // 4. Zapis zmian w bazie danych
        $setting->save();

        // Przekierowanie z komunikatem sukcesu
        return redirect()->route('settings.panelList')->with('success', 'Ustawienie zostało zaktualizowane.');
    }

    public function edit($id)
    {
        // Pobierz wpis na podstawie ID
        $setting = GeneralSetting::with(['updatedByUser'])->findOrFail($id);

        // Wyślij dane do widoku
        return view('panel.auth.settings.update', compact('setting'));
    }

}
