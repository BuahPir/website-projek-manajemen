<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskActivity extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'task_id',
        'activity_date',
        'file_path',
        'activity_name',
    ];

    /**
     * Get the task that owns the activity.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
