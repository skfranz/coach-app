<?php

/*
Program Name: Console.php
Description: Declares a console command for use in having repeating tasks
Input: None
Output: None
*/

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\RepeatTasks;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(RepeatTasks::class)->daily();
