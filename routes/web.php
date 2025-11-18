<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SubtaskController;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Cosmetic;

// Returns webpage with all tasks (that haven't been completed)
Route::get('/', function (){
    return view('taskpage', ['tasks' => Task::where('complete_status', false)->get(), 'tags' => Tag::where('complete_status', false)->get()]);
})->name('tasks.index');

// Returns webpage with all completed tasks/tags
Route::get('/completed', function (){
    return view('completed', ['tasks' => Task::where('complete_status', true)->get(), 'tags' => Tag::all()]);
})->name('completed.index');

// Show all (incompleted) tags
Route::get('/tags',  function() {
    return view('tagpage', ['tags' => Tag::where('complete_status', false)->get(), 'tasks' => Tag::where('complete_status', false)->get()]);
})->name('tags.index');


// Returns shop main page
Route::get('/shoppage', function () {
    return view('shoppage');
})->name('shoppage.index');

// Returns font shop page with all font cosmetics
Route::get('/fontshop', function () {
    return view('fontshop', ['cosmetics' => Cosmetic::where([['type', 'font'], ['purchased_status', false]])->get()]);
})->name('fontshop.index');

// Returns text color shop page with all text color cosmetics
Route::get('/textcolorshop', function () {
    return view('textcolorshop', ['cosmetics' => Cosmetic::where([['type', 'textcolor'], ['purchased_status', false]])->get()]);
})->name('textcolorshop.index');

// Returns background shop page with all background cosmetics
Route::get('/backgroundshop', function () {
    return view('backgroundshop', ['cosmetics' => Cosmetic::where([['type', 'background'], ['purchased_status', false]])->get()]);
})->name('backgroundshop.index');

// Returns coach shop page with all coach cosmetics
Route::get('/coachshop', function () {
    return view('coachshop', ['cosmetics' => Cosmetic::where([['type', 'coach'], ['purchased_status', false]])->get()]);
})->name('coachshop.index');

// Returns inventory main page
Route::get('/inventorypage', function () {
    return view('inventorypage');
})->name('inventorypage.index');

// Returns font shop inventory with all owned font cosmetics
Route::get('/fontinv', function () {
    return view('fontinv', ['cosmetics' => Cosmetic::where([['type', 'font'], ['purchased_status', true]])->get()]);
})->name('fontinv.index');

// Returns text color inventory page with all owned text color cosmetics
Route::get('/textcolorinv', function () {
    return view('textcolorinv', ['cosmetics' => Cosmetic::where([['type', 'textcolor'], ['purchased_status', true]])->get()]);
})->name('textcolorinv.index');

// Returns background inventory page with all owned background cosmetics
Route::get('/backgroundinv', function () {
    return view('backgroundinv', ['cosmetics' => Cosmetic::where([['type', 'background'], ['purchased_status', true]])->get()]);
})->name('backgroundinv.index');

// Returns coach inventory page with all owned coach cosmetics
Route::get('/coachinv', function () {
    return view('coachinv', ['cosmetics' => Cosmetic::where([['type', 'coach'], ['purchased_status', true]])->get()]);
})->name('coachinv.index');

Route::resource('tasks.subtasks', SubtaskController::class);

Route::post('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Post request link for creating a task, which routes it to the TaskController "create" function (and adds specific route name "tasks.create")
Route::delete('/tasks/delete/{task}', [TaskController::class, 'delete'])->name('tasks.delete');
Route::patch('/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/complete/{task}', [TaskController::class, 'complete'])->name('tasks.complete'); // Route to complete/undo completing a task
Route::patch('/tasks/detach/{task}/{tag}', [TaskController::class, 'detach'])->name('tasks.detach');

Route::post('/tags/create', [TagController::class, 'create'])->name('tags.create');
Route::delete('/tags/delete/{tag}', [TagController::class, 'delete'])->name('tags.delete');
Route::patch('/tags/update/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::patch('/tags/complete/{tag}', [TagController::class, 'complete'])->name('tags.complete');
Route::patch('/tags/detach/{tag}/{task}', [TagController::class, 'detach'])->name('tags.detach');
