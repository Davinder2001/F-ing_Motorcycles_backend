<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'about_us';

    // The attributes that are mass assignable
    protected $fillable = [
        'title',
        'description',
        'seoTitle',         // Added fields
        'seoDescription',
        'seoHostUrl'
    ];

    // If you want to define relationships or custom methods, you can add them here
}
