<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Table name in the database

    // Pola, które można masowo przypisywać
    protected $fillable = [
        'title',
        'url',
        'template_type',
        'content',
        'parent_category_id',
        'is_hidden',
        'hide_before_time',
        'created_by',
        'updated_by',
    ];

    // Date fields
    protected $dates = [
        'hide_before_time',
        'created_at',
        'updated_at',
    ];


    // Relation to the user who created the post
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation to the user who updated the post
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relation to the parent category 
    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    // public function findParentCategoriesForPost($postId, array &$parents = []): array {
    //     /**
    //      * Recursively finds all parent categories for a given post ID.
    //      *
    //      * @param int $postId The ID of the post to find parent categories for.
    //      * @param array $parents An array to store the parent categories (passed by reference).
    //      * @return array An array of parent categories, including the category of the post.
    //      */
        
    //     if ($postId === null) {
    //         return $parents;
    //     }
    
    //     $post = Post::find($postId);
    
    //     if ($post && $post->parent_category_id !== null) {
    //         $category = Category::find($post->parent_category_id);
    
    //         if ($category) {
    //             $parents[] = $category;
    
    //             if ($category->parent_id !== null) {
    //                 $this->findParentCategories($category->parent_id, $parents);
    //             }
    //         }
    //     }
    
    //     return $parents;
    // }    

}
