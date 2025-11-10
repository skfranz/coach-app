<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\Cosmetic;

// Returns webpage with all tasks (that haven't been completed)
Route::get('/', function (){
    return view('taskpage', ['tasks' => Task::where('complete_status', false)->get()]);
})->name('tasks.index');

// Returns webpage with all completed tasks
Route::get('/completed', function (){
    return view('completed', ['tasks' => Task::where('complete_status', true)->get()]);
})->name('completed.index');

// Returns shop main page
Route::get('/shoppage', function () {
    return view('shoppage');
})->name('shoppage.index');

Route::get('/fontshop', function () {
    return view('fontshop', ['cosmetics' => Cosmetic::where('type', 'font')->get()]);
})->name('fontshop.index');

Route::get('/textcolorshop', function () {
    return view('textcolorshop', ['cosmetics' => Cosmetic::where('type', 'textcolor')->get()]);
})->name('textcolorshop.index');

Route::get('/backgroundshop', function () {
    return view('backgroundshop', ['cosmetics' => Cosmetic::where('type', 'background')->get()]);
})->name('backgroundshop.index');

Route::get('/coachshop', function () {
    return view('coachshop', ['cosmetics' => Cosmetic::where('type', 'coach')->get()]);
})->name('coachshop.index');

Route::post('/create', [TaskController::class, 'create'])->name('tasks.create');// Post request link for creating a task, which routes it to the TaskController "create" function (and specific route name "tasks.create")
Route::delete('/delete/{task}', [TaskController::class, 'delete'])->name('tasks.delete'); // Route to delete task
Route::patch('/update/{task}', [TaskController::class, 'update'])->name('tasks.update'); // Route to update task
Route::patch('/complete/{task}', [TaskController::class, 'complete'])->name('tasks.complete'); // Route to complete/undo completing a task