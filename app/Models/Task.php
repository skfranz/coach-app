<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    
    protected $table = 'tasks'; // Assigns model to SQL table 'tasks'

    protected $fillable = [ // Determines which variables/columns are editable by the user
        'name',
        'description',
        'difficulty',
        'coin_value',
        'complete_status',
        'repeats'
    ];

    // Tasks have a many-to-many relationship with tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id');
    }

    public function subtasks()
    {
        // a task can have zero, one or multiple different subtasks related to it.
        return $this->hasMany(Subtask::class);
    }
}
