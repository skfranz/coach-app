<?php

/*
Program Name: Tags table
Description: Holds user data regarding each tag created by the user. Fields include name, description and whether or not the tag is completed.
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
        Schema::create('tags', function (Blueprint $table) { // Create SQL table 'tags' and columns
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('complete_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
