<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Metoda do wyświetlania wszystkich kategorii
    public function index()
    {
        // Pobierz wszystkie kategorie z bazy danych
        $categories = Category::all();

        // Proste wyświetlenie wyników
        foreach ($categories as $category) {
            echo "$category <br>";
            // echo "ID: " . $category->id . ", Name: " . $category->name . "<br>";
        }
    }
}