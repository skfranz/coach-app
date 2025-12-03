<?php

/*
Program Name: Tasks table
Description: Holds user data regarding each task that has been created by the user. Fields include name, description, difficulty, coin value, whether or not the task is completed and if it repeats
Input: None.
Output: The aforementioned database table.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) { // Create SQL table 'tasks' and columns
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('difficulty');
            $table->integer('coin_value');
            $table->boolean('complete_status')->default(0);
            $table->boolean('repeats')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
