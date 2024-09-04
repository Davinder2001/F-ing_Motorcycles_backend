<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'investors';

    // The attributes that are mass assignable.
    protected $fillable = [
        'field1',
        'field2',
        'field3',
        'field4',
        'field5',
        'field6',
        'field7',
        'field8',
        'field9',
        'image',
    ];

    // Optional: Define relationships if needed
}
