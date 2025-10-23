<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Models\Task;

Route::get('/', function (){
    return view('taskpage', ['tasks' => Task::all()]);
})->name('tasks.index');

Route::post('/create', [TaskController::class, 'create'])->name('tasks.create');
Route::delete('/delete/{task}', [TaskController::class, 'delete'])->name('tasks.delete');