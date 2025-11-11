<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    protected $table = 'cosmetics'; // Assigns model to SQL table 'tasks'

    protected $fillable = [ // Determines which variables/columns are editable by the user
        'name',
        'type',
        'description',
        'purchaseable',
        'price'
    ];
}