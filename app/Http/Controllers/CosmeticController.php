<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cosmetic;
use App\Models\Gamestate;

class CosmeticController extends Controller
{
    public function buy(Cosmetic $cosmetic) {

        $gamestate = Gamestate::find(1);
        
        if ($gamestate->total_coins >= $cosmetic->price) {
            $gamestate->update(['total_coins' => $gamestate->total_coins -= $cosmetic->price]);
            $cosmetic->update(['purchased_status' => true]);
            $gamestate->update(['current_background' => $cosmetic->name]);
        }

        return redirect()->route('shop.index');
    }
}
