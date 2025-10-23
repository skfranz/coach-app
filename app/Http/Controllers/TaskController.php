<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
                'name' => ['required'],
                'description' => ['nullable'],
            ]);

        Task::create($data);
        return redirect()->route('tasks.index');
    }

    public function delete(Task $task) {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
