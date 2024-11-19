<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function store(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);
        return redirect()->route('projects.tasks.index', $projectId);
    }
}
