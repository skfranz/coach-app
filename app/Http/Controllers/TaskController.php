<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;

class TaskController extends Controller
{
    // Creates a new task
    public function create(Request $request)
    {
        // Takes data from "Create Task Form" request and checks it - if failed, don't create new task
        $data = $request->validate([
                'name' => ['required'],         // Name (from form) is required
                'description' => ['nullable'],  // Description is optional
            ]);

        $task = Task::create($data);    // If successful, create new item with form data
        $tags = request('tags');        // Get tag ids from tag input box
        $task->tags()->attach($tags);   // Attach tag ids to task-tag Eloquent relationship, updating pivot table task_tag

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
            ]);

        $task->update($data); // If form has all required components, update data
        $tags = request('tags');        // Get tag ids from tag input box
        $task->tags()->detach();        // Detach existing tags
        $task->tags()->attach($tags);   // Attach tag ids to task-tag Eloquent relationship, updating pivot table task_tag
        return back();  // Refresh/return back to page
    }

    // Changes the Task's 'complete_status' - Used to complete a task or "undo" a completed task
    public function complete(Task $task) {
        $task->update(['complete_status' => !$task->complete_status]); // Update complete_status to the opposite of what it was
        return back();
    }

    // Detach a specific tag from a task
    public function detach(Task $task, Tag $tag) {
        $task->tags()->detach($tag);
        return back();
    }
}
