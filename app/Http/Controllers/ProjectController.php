<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Show the form to create a new project.
     */
    public function create()
    {
        $team = Team::where('leader_id', Auth::id())->first();

        // Only show the form if the user is a team leader
        if (!$team) {
            return redirect()->route('dashboard')->with('error', 'Only team leaders can create projects.');
        }

        return view('projects.create', compact('team'));
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        // Check if the user is the leader of any team
        $team = Team::where('leader_id', Auth::id())->first();

        if (!$team) {
            return redirect()->back()->with('error', 'Only team leaders can create projects.');
        }

        // Validate the input
        $request->validate([
            'name_project' => 'required|string|max:255',
            'description_project' => 'nullable|string',
        ]);

        // Create a new project
        Project::create([
            'name' => $request->input('name_project'),
            'description' => $request->input('description_project'),
            'team_id' => $team->id,
        ]);

        return redirect()->route('projects')->with('success', 'Project created successfully!');
    }
        public function index()
    {
        // Retrieve the team of the authenticated user
        $team = Auth::user()->team;

        // Retrieve all projects associated with the user's team
        $projects = $team ? $team->projects : collect();

        return view('projects', compact('projects'));
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Optional: Only allow the team leader to delete the project
        if (Auth::user()->id !== $project->team->leader_id) {
            return redirect()->route('projects')->with('error', 'You do not have permission to delete this project.');
        }

        $project->delete();

        return redirect()->route('projects')->with('success', 'Project deleted successfully!');
    }
    public function indexAdmin()
    {
        $projects = Project::with('team', 'team.leader')->get(); // Assuming 'team' and 'team.leader' relationships exist
        return view('admin.manage_projects', compact('projects'));
    }
    public function destroyAdmin($id)
    {
        $project = Project::findOrFail($id);

        // Optional: Only allow the team leader to delete the project
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully!');
    }
}
