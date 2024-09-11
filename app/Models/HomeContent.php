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
        's_description_1',  // Added field
        's_description_2',  // Added field
        's_description_3',  // Added field
        'third_sec_heading', // Added field
        'image_1_sec_3',    // Added field
        'disc_1_sec_3',     // Added field
        'image_2_sec_3',    // Added field
        'disc_2_sec_3',     // Added field
        'image_3_sec_3',    // Added field
        'disc_3_sec_3',     // Added field
        'image_4_sec_3',    // Added field
        'disc_4_sec_3',     // Added field
        'image_5_sec_3',    // Added field
        'disc_5_sec_3',     // Added field
        'button_1',         // Existing field
        'button_2',         // Existing field
    ];
}
