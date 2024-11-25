<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    // Display the form for creating a new team
    // Store the newly created team and associate selected users
    public function store(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'name_team' => 'required|string|max:255',
            'selected_users' => 'array|max:3', // Limit to 3 selected users (excluding the leader)
        ]);

        $leader = Auth::user(); // Get the authenticated user (the team creator)

        // Check if the leader is already in a team
        if ($leader->team_id) {
            return redirect()->back()->withErrors([
                'leader' => "You are already part of a team and cannot create another one."
            ])->withInput();
        }

        // Check if any selected user is already in a team
        $existingTeamMembers = User::whereIn('id', $request->input('selected_users', []))
                                   ->whereNotNull('team_id')
                                   ->get();

        if ($existingTeamMembers->isNotEmpty()) {
            $userNames = $existingTeamMembers->pluck('name')->join(', ');
            return redirect()->back()->withErrors([
                'selected_users' => "The following users are already in a team: $userNames. Please select users who are not already in a team."
            ])->withInput();
        }

        // Create a new team with the authenticated user as the leader
        $team = Team::create([
            'name' => $request->input('name_team'),
            'leader_id' => $leader->id, // Set the leader_id here
        ]);

        // Set the leader as a member of the new team
        $leader->team_id = $team->id;
        $leader->save();

        // Attach selected users to the team
        $selectedUsers = $request->input('selected_users', []);
        foreach ($selectedUsers as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->team_id = $team->id;
                $user->save();
            }
        }

        return redirect()->route('teams')->with('success', 'Team created successfully, and you are assigned as the team leader!');
    }


    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        // Optional: Ensure only leaders or admins can delete teams
        if (Auth::id() !== $team->leader_id) {
            return redirect()->route('teams')->with('error', 'You do not have permission to delete this team.');
        }

        // Delete the team
        $team->delete();

        return redirect()->route('teams')->with('success', 'Team deleted successfully!');
    }

    // Optional: Display a list of all teams
    public function index()
    {
        $allTeams = Team::with('users')->get(); // Load teams with their associated users
        $users = User::doesntHave('team')->get();
        return view('teams', compact('allTeams', 'users'));
    }
    public function indexAdmin()
    {
        $teams = Team::with('leader', 'users')->get(); // Assuming leader and users relations exist
        return view('admin.manage_teams', compact('teams'));
    }
    public function destroyAdmin($id)
    {
        $team = Team::findOrFail($id);

        // Delete the team
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully!');
    }
}
