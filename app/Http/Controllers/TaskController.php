<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Save task in database
        $task = Task::create([
            'title' => $request->title
        ]);

        event(new TaskCreated($task));

        return response()->json([
            'message' => 'Task Created Successfully',
            'task' => $task
        ]);
    }
}
