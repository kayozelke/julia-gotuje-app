<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Nazwa tabeli w bazie danych

    // Pola, które można masowo przypisywać
    protected $fillable = [
        'name',
        'parent_id',
        'updated_by',
    ];

    // Pola dat
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    
    public function findParentCategories($categoryId, array &$parents = []): array {/**
        * Recursively finds all parent categories for a given category ID.
        *
        * @param int $categoryId The ID of the category to find parents for.
        * @param array $parents An array to store the parent categories (passed by reference).
        * @return array An array of parent categories, including the initial category.
        */
        
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
}