<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Fillable attributes
    protected $fillable = ['name', 'short_description', 'long_description', 'category_image' => ''];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
