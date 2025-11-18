<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
            $table->boolean('purchased_status')->default(0);
            $table->integer('price');
            $table->timestamps();
        });

        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '1',
            'name' => 'Text Color Shop Test',
            'type' => 'textcolor',
            'purchased_status' => '0',
            'price' => '100',
        ]);
        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '2',
            'name' => 'Text Color Inventory Test',
            'type' => 'textcolor',
            'purchased_status' => '1',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '3',
            'name' => 'Font Shop Test',
            'type' => 'font',
            'purchased_status' => '0',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '4',
            'name' => 'Font Inventory Test',
            'type' => 'font',
            'purchased_status' => '1',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '5',
            'name' => 'Background Shop Test',
            'type' => 'background',
            'purchased_status' => '0',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([       // Create a default user/gamestate
            'id' => '6',
            'name' => 'Background Inventory Test',
            'type' => 'background',
            'purchased_status' => '1',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([
            'id' => '7',
            'name' => 'Coach Shop Test',
            'type' => 'coach',
            'purchased_status' => '0',
            'price' => '100'
        ]);
        DB::table('cosmetics')->insert([
            'id' => '8',
            'name' => 'Coach Inventory Test',
            'type' => 'coach',
            'purchased_status' => '1',
            'price' => '100'
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