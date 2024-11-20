<?php

namespace App\Http\Controllers;

use App\Models\TaskActivity;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskActivityController extends Controller
{
    /**
     * Display a listing of the activities for a specific task.
     */
    public function index($taskId)
    {
        $task = Task::with('activities')->findOrFail($taskId);

        return view('projects.tasks.index', compact('task'));
    }


    public function download($projectId, $taskId, $fileName)
    {
        $filePath = 'pictures/' . $fileName;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(storage_path('app/public/pictures/' . $filePath), $fileName);
        }

        return abort(404, 'File not found.');
    }


    /**
     * Store a newly created activity in the database.
     */
    public function store(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date', // Ensures it's a valid date
            'file_path' => 'nullable|file',
            'description' => 'nullable|string',
        ]);

        // Format the date to `Y-m-d`
        $formattedDate = \Carbon\Carbon::createFromFormat('m/d/Y', $request->input('activity_date'))->format('Y-m-d');

        // Handle file upload if exists
        if ($request->hasFile('file_path')) {
            $originalName = $request->file('file_path')->getClientOriginalName(); // Get the original file name
            $generatedName = $request->file('file_path')->hashName(); // Generate a unique file name
            $filePath = $request->file('file_path')->storeAs('', $generatedName, 'public'); // Save the file with a generated name

            TaskActivity::create([
                'task_id' => $taskId,
                'activity_name' => $request->input('activity_name'),
                'activity_date' => $request->input('activity_date') ?? now(),
                'description' => $request->input('description'),
                'file_path' => $filePath,
                'original_file_name' => $originalName, // Save the original file name
            ]);
        } else {
            TaskActivity::create([
                'task_id' => $taskId,
                'activity_name' => $request->input('activity_name'),
                'activity_date' => $request->input('activity_date') ?? now(),
                'description' => $request->input('description'),
                'file_path' => null,
                'original_file_name' => null,
            ]);
        }

        return redirect()->route('projects.tasks.index', $projectId)->with('success', 'Activity added successfully.');
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
     * Update the specified activity in the database.
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
            // Delete the old file if it exists
            if ($activity->file_path && Storage::exists($activity->file_path)) {
                Storage::delete($activity->file_path);
            }

            $activity->file_path = $request->file('file_path')->store('task_activities_files');
        }

        $activity->update([
            'activity_name' => $request->input('activity_name'),
            'activity_date' => $request->input('activity_date'),
        ]);

        return redirect()->route('tasks.activities.index', $taskId)
            ->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity from the database.
     */
    public function destroy($taskId, $activityId)
    {
        $activity = TaskActivity::where('task_id', $taskId)->findOrFail($activityId);

        // Delete the file if it exists
        if ($activity->file_path && Storage::exists($activity->file_path)) {
            Storage::delete($activity->file_path);
        }

        $activity->delete();

        return redirect()->route('tasks.activities.index', $taskId)
            ->with('success', 'Activity deleted successfully.');
    }
}
