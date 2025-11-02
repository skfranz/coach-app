<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    // Creates a new task
    public function create(Request $request)
    {
        // Takes data from "Create Task Form" request and checks it - if failed, don't create new task
        $data = $request->validate([
                'name' => ['required'],         // Name (from form) is required
                'description' => ['nullable'],  // Description is optional
                'difficulty' => ['required'],
            ]);

        if ($data['difficulty'] == 'Easy') {
            $data['coin_value'] = 50;
        } elseif ($data['difficulty'] == 'Medium') {
            $data['coin_value'] = 100;
        } elseif ($data['difficulty'] == 'Hard') {
            $data['coin_value'] = 150;
        } elseif ($data['difficulty'] == 'Very Hard') {
            $data['coin_value'] = 200;
        }
        Task::create($data);    // If successful, create new item with form data
        return redirect()->route('tasks.index'); // Return to tasks page
    }

    // Delete a task (Delete form submits $task object)
    public function delete(Task $task) {
        $task->delete();
        return back();
    }

    // Update an existing task with new data
    public function update(Request $request, Task $task) {

        // Validation for update form
        $data = $request->validate([
                'name' => ['required'],         // Name is required
                'description' => ['nullable'],  // Description is optional
                'difficulty' => ['required'],
            ]);

        if ($data['difficulty'] == 'Easy') {
            $data['coin_value'] = 50;
        } elseif ($data['difficulty'] == 'Medium') {
            $data['coin_value'] = 100;
        } elseif ($data['difficulty'] == 'Hard') {
            $data['coin_value'] = 150;
        } elseif ($data['difficulty'] == 'Very Hard') {
            $data['coin_value'] = 200;
        }

        $task->update($data); // If form has all required components, update data
        return back();  // Refresh/return back to page
    }

    // Changes the Task's 'complete_status' - Used to complete a task or "undo" a completed task
    public function complete(Task $task) {
        $task->update(['complete_status' => !$task->complete_status]); // Update complete_status to the opposite of what it was
        return back();
    }
}
