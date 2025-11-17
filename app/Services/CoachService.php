<?php

namespace App\Services;

use App\Models\Task;

// This class exists to pick lines to return to the client as Coach lines, depending on the Coach settings and context.
class CoachService
{
    public function getLine(string $coach, string $action, Task $task): string
    {
        // get the relevant lines from the config file
        $lines = config("coach_lines.$coach.$action.default") ?? [];

        // pick a random line
        $line = $lines[array_rand($lines)];

        return $line;
    }
}
