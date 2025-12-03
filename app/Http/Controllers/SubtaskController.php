<?php

/*
Program Name: SubtaskController.php
Description: Defines functionality for user interaction with subtasks
Input: Subtask model corresponding to an entry in the Subtasks database table
Output: Functionality for storing, editing, and deleting subtasks
*/

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $task->subtasks()->create([ 'description' => $request->description, ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task, Subtask $subtask)
    {
        $subtask->update([
            'complete_status' => $request->boolean('complete_status'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Subtask $subtask)
    {
        $subtask->delete();

        return back();
    }
}
