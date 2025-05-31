<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'status', 'due_date', 'user_id', 'parent_id'];

    //Define Model relationships
    // A task can have a parent task and multiple subtasks

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }
    // A task can have multiple subtasks
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
    // A task belongs to a user
    // This is the user who created the task
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
