<?php

namespace App\Http\Controllers;

use App\Models\TaskActivity;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TaskActivityAdded;
use App\Models\Project;

class TaskActivityController extends Controller
{
    /**
     * Display a listing of the activities for a specific task.
     */
    public function index($projectId,$taskId)
    {
        $project = Project::with(['tasks.activities', 'team'])->findOrFail($projectId);
        $task = $project->tasks->where('id', $taskId)->firstOrFail();

        return view('projects.tasks.index', compact('task'));
    }

    /**
     * Download the file associated with the activity.
     */
    public function download($projectId, $taskId, $fileName)
    {
        $filePath = 'pictures/' . $fileName;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(storage_path('app/public/pictures/' . $filePath), $fileName);
        }

        return abort(404, 'File not found.');
    }

    /**
     * Store a newly created activity in the database and send notifications.
     */
    public function store(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'file_path' => 'nullable|file',
            'description' => 'nullable|string',
        ]);

        // Validate project and task association
        $task = Task::where('id', $taskId)->whereHas('project', function ($query) use ($projectId) {
            $query->where('id', $projectId);
        })->firstOrFail();

        $formattedDate = \Carbon\Carbon::createFromFormat('m/d/Y', $request->input('activity_date'))->format('Y-m-d');

        $filePath = null;
        $originalName = null;

        if ($request->hasFile('file_path')) {
            $originalName = $request->file('file_path')->getClientOriginalName();
            $generatedName = $request->file('file_path')->hashName();
            $filePath = $request->file('file_path')->storeAs('', $generatedName, 'public');
        }

        $activity = $task->activities()->create([
            'activity_name' => $request->input('activity_name'),
            'activity_date' => $formattedDate,
            'description' => $request->input('description'),
            'file_path' => $filePath,
            'original_file_name' => $originalName,
        ]);

        // Notify all team members
        $teamUsers = $task->project->team->users;

        foreach ($teamUsers as $user) {
            $user->notify(new TaskActivityAdded($activity));
        }

        return redirect()->route('projects.tasks.index', $projectId)->with('success', 'Activity added successfully and users notified.');
    }


    /**
     * Show the form for editing the specified activity.
     */
    public function edit($taskId, $activityId)
    {
        $activity = TaskActivity::where('task_id', $taskId)->findOrFail($activityId);

        return view('task_activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in the database and notify users.
     */
    public function update(Request $request, $taskId, $activityId)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $activity = TaskActivity::where('task_id', $taskId)->findOrFail($activityId);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            if ($activity->file_path && Storage::exists($activity->file_path)) {
                Storage::delete($activity->file_path); // Delete the old file
            }

            $activity->file_path = $request->file('file_path')->store('task_activities_files');
        }

        $activity->update([
            'activity_name' => $request->input('activity_name'),
            'activity_date' => $request->input('activity_date'),
            'description' => $request->input('description'),
        ]);

        // Notify all team members about the update
        $task = Task::findOrFail($taskId);
        $teamUsers = $task->project->team->users;

        foreach ($teamUsers as $user) {
            $user->notify(new TaskActivityAdded($activity)); // Update notification
        }

        return redirect()->route('tasks.activities.index', $taskId)
            ->with('success', 'Activity updated successfully and users notified.');
    }

    /**
     * Remove the specified activity from the database and notify users.
     */
    public function destroy($taskId, $activityId)
    {
        $activity = TaskActivity::where('task_id', $taskId)->findOrFail($activityId);

        // Delete the file if it exists
        if ($activity->file_path && Storage::exists($activity->file_path)) {
            Storage::delete($activity->file_path);
        }

        $activity->delete();

        // Notify all team members about the deletion
        $task = Task::findOrFail($taskId);
        $teamUsers = $task->project->team->users;

        foreach ($teamUsers as $user) {
            $user->notify(new TaskActivityAdded($activity)); // Notify about deletion
        }

        return redirect()->route('tasks.activities.index', $taskId)
            ->with('success', 'Activity deleted successfully and users notified.');
    }
}
