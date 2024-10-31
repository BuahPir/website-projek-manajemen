<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name'];

    // Define the relationship with User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
