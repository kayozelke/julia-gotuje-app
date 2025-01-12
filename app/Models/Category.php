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

    public function findChildrenCategories($categoryId, array &$childrens = []): array {/**

        * Recursively finds all child categories for a given category
        * @param int $categoryId The ID of the category to find children2 for.
        * @param array $childrens An array to store the child categories (passed by reference).
        * @return array An array of child categories.
        */
        // print_r("findChildrenCategories(): ".$categoryId."<br>");
        
        $own_childrens = Category::where('parent_id', $categoryId)->get();

        foreach ($own_childrens as $child) {
            array_push($childrens, $child->id);
            $this->findChildrenCategories($child->id, $childrens);
        }

        return $childrens;
    }

    // Relation to the user who updated the category
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
