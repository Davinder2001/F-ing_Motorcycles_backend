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
        'heading_2',
        'Sub_heading_2',
        'description_2',
        's_description_1',
        's_description_2',
        's_description_3',
        'image',
        'image_2',
        'third_sec_heading',
        'image_1_sec_3',
        'disc_1_sec_3',
        'image_2_sec_3',
        'disc_2_sec_3',
        'image_3_sec_3',
        'disc_3_sec_3',
        'image_4_sec_3',
        'disc_4_sec_3',
        'image_5_sec_3',
        'disc_5_sec_3',

        // SEO Fields
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];
}
