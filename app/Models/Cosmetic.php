<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    protected $table = 'cosmetics'; // Assigns model to SQL table 'cosmetics'

    protected $fillable = [ // Determines which variables/columns are creatable
        'name',
        'type',
        'description',
        'price',
        'purchased_status',
    ];
}