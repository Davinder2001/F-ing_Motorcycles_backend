<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageSEO extends Model
{
    use HasFactory;


    protected $table = 'contact_pages_seo';

    protected $fillable = [
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

}
