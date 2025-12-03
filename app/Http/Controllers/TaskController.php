<?php

/*
Program Name: TaskController.php
Description: Defines functionality for user interaction with Tasks
Input: Subtask model corresponding to an entry in the Tasks database table
Output: Functionality for creating, editing, completing, sorting, and deleting tasks and detaching tags
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Tag;
use App\Services\CoachService;
use App\Models\Gamestate;

class TaskController extends Controller
{
    private CoachService $coach;
    private string $coachName = 'Goat'; // specify which coach to use, should change to currently selected one later

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

        // map difficulty to coin value for each task
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

        date_default_timezone_set('America/Chicago'); // set default timezone to US Central
        $task->update(['completed_at' => date(DATE_ATOM)]); // Update completed_at to the current DATE_ATOM timestamp

        $gamestate = Gamestate::find(1);

        if ($task->complete_status) { // When completing a task, add the task's coins to user's total amount
            $gamestate->update(['total_coins' => $gamestate->total_coins += $task->coin_value]);
        }
        else { // When undoing a completed task, subtract task's coins from user's total amount
            $subtract = $gamestate->total_coins -= $task->coin_value;
            $end_coins = ($subtract >= 0) ? $subtract : 0; // if user's coins is 0, return 0 (don't return negative)
            $gamestate->update(['total_coins' => $end_coins]);
        }

        $action = $task->complete_status ? "completing_task" : "uncompleting_task"; // determine whether the task is being completed or undone
        $line = $this->coachLine($action, $task);
        return back()->with('coach', $line); // return to previous page and send coach msg
    }

    // Detach a specific tag from a task
    public function detach(Task $task, Tag $tag) {
        $task->tags()->detach($tag);
        return back();
    }

    // List incompleted tasks with optional sorting
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'default'); // options: default|name|difficulty|tags
        $direction = strtolower($request->query('direction', 'asc')) === 'desc' ? 'desc' : 'asc';

        // base query
        $query = Task::where('complete_status', false)->with('tags');

        // apply sorting with a whitelist for safe columns
        if ($sort === 'name') {
            $tasks = $query->orderBy('name', $direction)->get();
        } elseif ($sort === 'difficulty') {
            $tasks = $query->orderBy('difficulty', $direction)->get();
        } elseif ($sort === 'tags') {
            // load tasks with tags and sort by concatenated tag names
            $tasks = $query->get()->sortBy(function ($task) {
                return $task->tags->pluck('name')->join(',');
            }, SORT_REGULAR, $direction === 'desc')->values();
        } else {
            // default = creation order
            $tasks = $query->orderBy('created_at', $direction)->get();
        }

        $tags = Tag::where('complete_status', false)->get();

        return view('taskpage', ['tasks' => $tasks, 'tags' => $tags]);
    }

    // List completed tasks with optional sorting
    public function completed(Request $request)
    {
        $sort = $request->query('sort', 'default'); // options: default|name|difficulty|tags
        $direction = strtolower($request->query('direction', 'asc')) === 'desc' ? 'desc' : 'asc';

        // base query for completed tasks
        $query = Task::where('complete_status', true)->with('tags');

        // apply sorting with whitelist for direct columns
        if ($sort === 'name') {
            $tasks = $query->orderBy('name', $direction)->get();
        } elseif ($sort === 'difficulty') {
            $tasks = $query->orderBy('difficulty', $direction)->get();
        } elseif ($sort === 'tags') {
            // load tasks with tags and sort by concatenated tag names
            $tasks = $query->get()->sortBy(function ($task) {
                return $task->tags->pluck('name')->join(',');
            }, SORT_REGULAR, $direction === 'desc')->values();
        } else {
            // default = creation order
            $tasks = $query->orderBy('created_at', $direction)->get();
        }

        $tags = Tag::all();

        return view('completed', ['tasks' => $tasks, 'tags' => $tags]);
    }
}
