<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/tasks', function () {
    return view('tasks');
});

Route::post('/create-task', [TaskController::class, 'store']);

Route::get('/test-broadcast', function () {
    event(new \App\Events\TaskCreated(\App\Models\Task::first()));
    return 'Sent';
});
