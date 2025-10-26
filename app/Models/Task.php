<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks'; // Assigns model to SQL table 'tasks'

    protected $fillable = [ // Determines which variables/columns are editable by the user
        'name',
        'description',
        'complete_status'
    ];
}
