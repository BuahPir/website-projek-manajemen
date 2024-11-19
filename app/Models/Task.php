<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
    ];

    /**
     * Get the project that owns the task.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the activities associated with the task.
     */
    public function activities()
    {
        return $this->hasMany(TaskActivity::class);
    }
}
