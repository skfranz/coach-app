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

    // Tags have a many-to-many relationship with tasks
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_tag', 'tag_id', 'task_id');
    }
}
