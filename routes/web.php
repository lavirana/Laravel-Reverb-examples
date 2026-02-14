<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Events\MessageSent;
use App\Events\OrderPlaced;

Route::get('/tasks', function () {
    return view('tasks');
});

Route::post('/create-task', [TaskController::class, 'store']);

Route::get('/test-broadcast', function () {
    event(new \App\Events\TaskCreated(\App\Models\Task::first()));
    return 'Sent';
});

Route::get('/chat', function () {
    return view('chat');
});

Route::post('/send-message', function () {
    broadcast(new MessageSent(request('message')))->toOthers();
    return response()->json(['status' => 'Message Sent']);
});


Route::get('/create-order', function (){
    return view('dashboard');
});


Route::post('/create-order', function () {

    $order = [
        'id' => rand(1,1000),
        'product' => 'Laptop',
        'price' => '800$'
    ];

    broadcast(new OrderPlaced($order));

    return response()->json($order);
});
Route::get('/dashboard', function () {
    return view('dashboard');
});