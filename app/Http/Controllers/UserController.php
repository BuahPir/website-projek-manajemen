<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUserSelect()
    {
        $users = User::all(); // Fetch all users from the database
        return view('create_teams', compact('users'));
    }
}
