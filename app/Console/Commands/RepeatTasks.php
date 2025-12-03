<?php

/*
Program Name: RepeatTasks.php
Description: Defines console command that runs for creating repeatable tasks
Input: None
Output: Functionality for making repeatable tasks
*/

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class RepeatTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repeat-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get every task that repeats and replace them with an identical task with complete_status = 0.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $repeatingTasks = Task::where('repeats', true)->get();
        foreach ($repeatingTasks as $task) {
            $newTask = $task->replicate();
            $newTask->created_at = now();
            $newTask->updated_at = now();
            $task->delete();
            $newTask->complete_status = 0;
            $newTask->save();
        }
    }
}
