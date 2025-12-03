<?php

/*
Program Name: Tag Task table
Description: An associative table holding user data that keeps track of the tasks that have been assigned to tags. Includes fields for the task’s id and the tag’s id.
Input: None
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
        Schema::create('task_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('task_id')->references('id')->on('tasks')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onUpdate('restrict')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tag');
    }
};
