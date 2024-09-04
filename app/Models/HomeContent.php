<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    // Define the table associated with the model (if not using Laravel's naming convention)
    protected $table = 'home_content';

    // Define the fillable attributes
    protected $fillable = [
        'heading',
        'heading_nxt',
        'description',
        'image',
        'image_2',
        'Sub_heading_2',
        'heading_2',
        'description_2',
        'button_1', // Added field
        'button_2',
    ];
}
