<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller {

    public function panelList(Request $request){
        // Pobierz wszystkie ustawienia z bazy
        $settings = GeneralSetting::all();

        // Wyślij ustawienia do widoku
        return view('panel.auth.settings.list', ['settings' => $settings]);
    }
    
    public function panelUpdate(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'id' => 'required|exists:general_settings,id',
            'value' => 'required|string',
        ]);

        // Pobierz wpis na podstawie ID
        $setting = GeneralSetting::findOrFail($request->input('id'));

        // Aktualizacja wartości oraz osoby aktualizującej
        $setting->value = $request->input('value');
        $setting->updated_by = Auth::id();
        $setting->updated_at = now();
        $setting->save();

        // Przekierowanie z komunikatem sukcesu
        return redirect()->route('settings.panelList')->with('success', 'Ustawienie zostało zaktualizowane.');
    }
}