<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags'; // Assigns model to SQL table 'tags'

    protected $fillable = [ // Determines which variables/columns are editable by the user
        'name',
        'description',
        'complete_status'
    ];
}
