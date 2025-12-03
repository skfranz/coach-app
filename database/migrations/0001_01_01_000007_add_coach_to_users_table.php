<?php

/*
Program Name: 0001_01_01_000007_add_coach_to_users_table.php
Description: Adds a coach field to the users table
Input: None
Output: Coach column added to users table
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('coach')
                  ->default('goat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('coach');
        });
    }
};
