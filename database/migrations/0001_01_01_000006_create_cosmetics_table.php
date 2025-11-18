<?php

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
            $table->string('description')->nullable();
            $table->integer('price');
            $table->boolean('purchased_status')->default(0);
            $table->timestamps();
        });

        Cosmetic::create([
            'name' => 'red',
            'type' => 'background',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'blue',
            'type' => 'background',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'green',
            'type' => 'background',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'yellow',
            'type' => 'background',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'pink',
            'type' => 'background',
            'price' => 500,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosmetics');
    }
};