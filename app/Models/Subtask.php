<?php

/*
Program Name: Subtask.php
Description: Defines what fields of a Subtask table entry are editable and defines subtask-task relationship
Input: None
Output: Changeability of Subtask table entries and subtask-parent relationship
*/

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
