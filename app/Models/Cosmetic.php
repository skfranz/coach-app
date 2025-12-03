<?php

/*
Program Name: Cosmetic.php
Description: Defines what fields of a Cosmetic table entry are creatable
Input: None
Output: Changeability of Cosmetic table entries
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    protected $table = 'cosmetics'; // Assigns model to SQL table 'cosmetics'

    protected $fillable = [ // Determines which variables/columns are creatable
        'name',
        'type',
        'asset',
        'price',
        'purchased_status',
    ];
}
