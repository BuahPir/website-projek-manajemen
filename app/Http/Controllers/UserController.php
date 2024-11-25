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
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('admin.manage_users', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
