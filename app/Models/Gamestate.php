<?php

/*
Program Name: Gamestate.php
Description: Defines what fields of a Gamestate table entry are creatable
Input: None
Output: Changeability of Gamestate table entries
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamestate extends Model
{
    protected $table = 'gamestate'; // Assigns model to SQL table 'gamestate'

    protected $fillable = [ // Determines which variables/columns are creatable
        'name',
        'total_coins',
        'current_background',
    ];
}
