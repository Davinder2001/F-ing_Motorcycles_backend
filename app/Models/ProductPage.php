<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPage extends Model
{
    use HasFactory;
    protected $table = 'product_page';
    protected $fillable = ['name', 'seo_title', 'seo_description', 'seo_keywords'];

}
