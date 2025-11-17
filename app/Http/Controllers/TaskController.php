<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use App\Services\CoachService;

class TaskController extends Controller
{
    private CoachService $coach;
    private string $coachName = 'Goat'; // hard coded for now, we can add requests to change it for this user later, I guess

    public function __construct(CoachService $coach)
    {
        $this->coach = $coach;
    }

    // helper function to get a line for the coach
    private function coachLine(string $action, Task $task): string
    {
        return $this->coach->getLine($this->coachName, $action, $task);
    }

    // Creates a new task
    public function create(Request $request)
    {
        // Takes data from "Create Task Form" request and checks it - if failed, don't create new task
        $data = $request->validate([
                'name' => ['required'],         // Name (from form) is required
                'description' => ['nullable'],  // Description is optional
                'difficulty' => ['required'],
                'repeats' => ['nullable']
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
        
        $task = Task::create($data);    // If successful, create new item with form data
        $tags = request('tags');        // Get tag ids from tag input box
        $task->tags()->attach($tags);   // Attach tag ids to task-tag Eloquent relationship, updating pivot table task_tag

        $line = $this->coachLine('creating_task', $task);

        return redirect()->route('tasks.index') // Return to tasks page
                         ->with('coach', $line); // tag with coach response
    }

    // Delete a task (Delete form submits $task object)
    public function delete(Task $task) {
        $temp = clone $task;
        $task->delete();

        $line = $this->coachLine('deleting_task', $task);

        return back()->with('coach', $line);
    }

    // Update an existing task with new data
    public function update(Request $request, Task $task) {

        // Validation for update form
        $data = $request->validate([
                'name' => ['required'],         // Name is required
                'description' => ['nullable'],  // Description is optional
                'difficulty' => ['required'],
                'repeats' => ['nullable']
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
        $tags = request('tags');        // Get tag ids from tag input box
        $task->tags()->syncWithoutDetaching($tags);   // Attach new tag ids to task-tag Eloquent relationship, updating pivot table task_tag

        $line = $this->coachLine('editing_task', $task);
        return back()->with('coach', $line);  // Refresh/return back to page
    }

    // Changes the Task's 'complete_status' - Used to complete a task or "undo" a completed task
    public function complete(Task $task) {
        $task->update(['complete_status' => !$task->complete_status]); // Update complete_status to the opposite of what it was

        $action = $task->complete_status ? "completing_task" : "uncompleting_task"; // determine whether the task is being completed or undone
        $line = $this->coachLine($action, $task);
        return back()->with('coach', $line); // return to previous page and send coach msg
    }

    // Detach a specific tag from a task
    public function detach(Task $task, Tag $tag) {
        $task->tags()->detach($tag);
        return back();
    }
}
