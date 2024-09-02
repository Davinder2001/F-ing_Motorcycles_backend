<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'home_content';

    // Define the fillable fields for mass assignment
    protected $fillable = ['heading', 'description', 'image'];
}
