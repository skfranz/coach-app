<?php

/*
Program Name: 0001_01_01_000006_create_cosmetics_table.php
Description: Creates a cosmetics database table with fields: id, name, type, description, price, and purchased_status, creates a few example entries in the table
Input: None
Output: Cosmetics database table with the mentioned fields, example entries in the table
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Cosmetic;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cosmetics', function (Blueprint $table) { // Create SQL table 'cosmetics' and columns
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('asset')->nullable();
            $table->integer('price');
            $table->boolean('purchased_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosmetics');
    }
};
