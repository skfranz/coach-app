<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table = 'subtasks'; // Assigns model to SQL table 'subtasks'

    protected $fillable = [ // Determines which variables/columns are editable by the user
        'description',
        'complete_status'
    ];

    public function task()
    {
        // each task belongs to one task
        return $this->belongsTo(Task::class);
    }
}
