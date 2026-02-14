<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Events\TaskCreated;
use App\Events\DashboardUpdated;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Save task in database
        $task = Task::create([
            'title' => $request->title
        ]);

         // Count total tasks
         $total = Task::count();

         // Broadcast event
         event(new DashboardUpdated($total));
 
        event(new TaskCreated($task));

        return response()->json([
            'message' => 'Task Created Successfully',
            'task' => $task
        ]);
    }
}
