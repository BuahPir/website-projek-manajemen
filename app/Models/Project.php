<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'team_id',
    ];

    /**
     * Get the team that owns the project.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
