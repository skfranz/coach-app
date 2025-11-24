<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Gamestate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gamestate', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('total_coins')->default(0);
            $table->string('current_background')->nullable();
            $table->timestamps();
        });

        Gamestate::create([       // Create a default gamestate
            'name' => 'default',
            'total_coins' => 0,
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
