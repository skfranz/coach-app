<?php

/*
Program Name: Web.php
Description: Defines webpages as routes and the initial parameters they load in with, also defines the routes for completing various database related actions
Input: None
Output: None
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\CosmeticController;
use App\Http\Controllers\CalendarController;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Cosmetic;

// Returns webpage with all tasks (that haven't been completed) and supports sorting
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Returns webpage with all completed tasks/tags and supports sorting (same options as the main page)
Route::get('/completed', [TaskController::class, 'completed'])->name('completed.index');

// Calendar view for completed tasks (month grid)
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

// Show all (incompleted) tags
Route::get('/tags',  function() {
    return view('tagpage', ['tags' => Tag::where('complete_status', false)->get(), 'tasks' => Tag::where('complete_status', false)->get()]);
})->name('tags.index');

// Returns shop main page
Route::get('/shop', function () {
    return view('shop', ['cosmetics' => Cosmetic::where('purchased_status', false)->get()]);
})->name('shop.index');

// Returns options/customizations page with bought cosmetics
Route::get('/options', function () {
    return view('options', ['cosmetics' => Cosmetic::where('purchased_status', true)->get()]);
})->name('options.index');

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

Route::patch('/shop/buy/{cosmetic}', [CosmeticController::class, 'buy'])->name('cosmetics.buy');
Route::patch('/options/equip/{cosmetic}', [CosmeticController::class, 'equip'])->name('cosmetics.equip');
