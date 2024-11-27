<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with summary and relevant data.
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user belongs to a team
        $userTeam = $user->team; // This will be null if the user doesn't belong to a team

        // Get the user's projects (only if the user belongs to a team)
        $projects = $userTeam
            ? Project::where('team_id', $userTeam->id)->get()
            : collect(); // Return an empty collection if no team

        // Get the user's active tasks (only if the user belongs to a team)
        $activeTasks = $userTeam
            ? Task::whereHas('project.team', function ($query) use ($userTeam) {
                $query->where('id', $userTeam->id);
            })->where('status', 'process')->get()
            : collect(); // Return an empty collection if no team

        // Get total completed tasks (only if the user belongs to a team)
        $completedTasksCount = $userTeam
            ? Task::whereHas('project.team', function ($query) use ($userTeam) {
                $query->where('id', $userTeam->id);
            })->where('status', 'done')->count()
            : 0; // Return 0 if no team

        // Get total team members (handle null teams)
        $usersInTeamsCount = $userTeam ? $userTeam->users()->count() : 0;


        return view('dashboard', [
            'projects' => $projects,
            'activeTasks' => $activeTasks,
            'completedTasksCount' => $completedTasksCount,
            'teamMembersCount' => $usersInTeamsCount,
            'totalProjectsCount' => $projects->count(),
            'activeTasksCount' => $activeTasks->count(),
        ]);
    }
}
