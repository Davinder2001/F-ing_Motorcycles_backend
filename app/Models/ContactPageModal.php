<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageModal extends Model
{
    use HasFactory;

    protected $table = 'contact_page';

    protected $fillable = ['name', 'email', 'number'];
    
}
