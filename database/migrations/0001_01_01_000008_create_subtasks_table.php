<?php

/*
Program Name: 0001_01_01_000008_create_subtasks_table.php
Description: Creates a subtasks database table with fields: id, task_id, description, and complete_status
Input: None
Output: Subtasks database table with the mentioned fields
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
        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            // restricts this variable to being a foreign key using task_id
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks')->onUpdate('restrict')->onDelete('cascade');

            $table->string('description');
            $table->boolean('complete_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};
