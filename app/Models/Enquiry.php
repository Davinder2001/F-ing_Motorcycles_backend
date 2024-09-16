<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the default "enquiries"
    protected $table = 'enquiries'; 

    // Define the fields that are fillable
    protected $fillable = ['name', 'email', 'phone', 'interestedIn', 'message'];


    // Optionally, you can specify any date columns like created_at, updated_at
    public $timestamps = true;
}



