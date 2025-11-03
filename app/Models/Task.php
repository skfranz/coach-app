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

    // Tasks have a many-to-many relationship with tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id');
    }
}
