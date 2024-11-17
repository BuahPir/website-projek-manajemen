<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks for a specific project.
     */
    public function index($projectId)
    {
        $project = Project::with('tasks.activities')->findOrFail($projectId);

        if (!$project->team->users->contains(Auth::id())) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to the tasks of this project.');
        }

        return view('tasks.index', compact('project'));
    }

    /**
     * Store a newly created task in the database.
     */
    public function store(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        // Check if the authenticated user is the team leader
        if (Auth::id() !== $project->team->leader_id) {
            return redirect()->route('tasks.index', $projectId)
                ->with('error', 'Only the team leader can create tasks.');
        }

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:process,done',
            'file' => 'nullable|file',
            'activity_date' => 'nullable|date',
            'comment' => 'nullable|string',
        ]);

        // Create the task
        $task = Task::create([
            'project_id' => $project->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        // Create initial task activity if there's a file, activity_date, or comment
        if ($request->hasFile('file') || $request->filled('activity_date') || $request->filled('comment')) {
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('tasks_files');
            }

            TaskActivity::create([
                'task_id' => $task->id,
                'activity_date' => $request->input('activity_date') ?? now(),
                'comment' => $request->input('comment') ?? 'Task created',
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('projects.tasks.index', $projectId)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->findOrFail($taskId);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in the database.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file',
            'activity_date' => 'nullable|date',
            'comment' => 'nullable|string',
        ]);

        $task = Task::where('project_id', $projectId)->findOrFail($taskId);

        // Only update name and description on the Task model
        $task->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Log updates for file, activity_date, and comment in TaskActivity
        if ($request->hasFile('file') || $request->filled('activity_date') || $request->filled('comment')) {
            $filePath = null;

            // Store the uploaded file if present
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('tasks_files');
            }

            // Log the activity
            TaskActivity::create([
                'task_id' => $task->id,
                'activity_date' => $request->input('activity_date') ?? now(),
                'comment' => $request->input('comment') ?? 'Task updated',
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('projects.tasks.index', $projectId)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from the database.
     */
    public function destroy($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)->findOrFail($taskId);

        // Check if the authenticated user is the team leader
        if (Auth::id() !== $task->project->team->leader_id) {
            return redirect()->route('projects.tasks.index', $projectId)
                ->with('error', 'Only the team leader can delete tasks.');
        }

        $task->delete();

        return redirect()->route('projects.tasks.index', $projectId)
            ->with('success', 'Task deleted successfully.');
    }
    public function updateStatus($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);

        // Ensure only the leader can update the status
        if (Auth::id() !== $project->team->leader_id) {
            return redirect()->route('projects.tasks.index', $projectId)->with('error', 'Only the leader can update the task status.');
        }

        $task = Task::where('project_id', $projectId)->findOrFail($taskId);

        // Toggle status
        $task->status = $task->status === 'process' ? 'done' : 'process';
        $task->save();

        return redirect()->route('projects.tasks.index', $projectId)->with('success', 'Task status updated successfully.');
    }

}
