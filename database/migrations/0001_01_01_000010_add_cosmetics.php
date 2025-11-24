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
        Cosmetic::create([
            'name' => 'White',
            'type' => 'background',
            'asset' => 'white',
            'price' => 0,
            'purchased_status' => true,
        ]);
        Cosmetic::create([
            'name' => 'Red',
            'type' => 'background',
            'asset' => 'red',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'Blue',
            'type' => 'background',
            'asset' => 'blue',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'Green',
            'type' => 'background',
            'asset' => 'green',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'Yellow',
            'type' => 'background',
            'asset' => 'yellow',
            'price' => 500,
        ]);
        Cosmetic::create([
            'name' => 'Pink',
            'type' => 'background',
            'asset' => 'pink',
            'price' => 500,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamestate');
    }
};
