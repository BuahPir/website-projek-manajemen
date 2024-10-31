<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Display the form for creating a new team
    public function create()
    {
        $users = User::all(); // Retrieve all users for the dropdown
        return view('create_teams', compact('users')); // Return the view with users data
    }

    // Store the newly created team and associate selected users
    public function store(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'name_team' => 'required|string|max:255',
            'selected_users' => 'array|max:3', // Limit to 3 selected users
        ]);

        // Create a new team
        $team = Team::create([
            'name' => $request->input('name_team'),
        ]);

        // Attach selected users to the team
        if ($request->has('selected_users')) {
            foreach ($request->input('selected_users') as $userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->team_id = $team->id;
                    $user->save();
                }
            }
        }

        return redirect()->route('teams')->with('success', 'Team created successfully!');
    }

    // Optional: Display a list of all teams
    public function index()
    {
        $teams = Team::with('users')->get(); // Load teams with their associated users
        return view('teams', compact('teams'));
    }
}
