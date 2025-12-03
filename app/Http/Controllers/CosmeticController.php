<?php

/*
Program Name: CosmeticController.php
Description: Defines the functionality of purchasing an item from the shop
Input: Cosmetic model corresponding to an entry in the Cosmetics database table
Output: Reduction in user’s coin amount by the cost of the item, change in price field of specified entry in the cosmetics database table, purchased_status set to true for specified entry in cosmetics database table
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cosmetic;
use App\Models\Gamestate;

class CosmeticController extends Controller
{
    // Purchase a cosmetic with coins
    public function buy(Cosmetic $cosmetic) {

        $gamestate = Gamestate::find(1);

        if ($gamestate->total_coins >= $cosmetic->price) { // If user has enough coins to buy cosmetic
            $gamestate->update(['total_coins' => $gamestate->total_coins -= $cosmetic->price]); // Subtract coins
            $cosmetic->update(['purchased_status' => true]); // Mark cosmetic as purchased
            $gamestate->update(['current_background' => $cosmetic->asset]);
        }
        else { // If user doesn't have enough coins, return error message stating the amount needed
            $needed_coins = $cosmetic->price - $gamestate->total_coins;
            return redirect()->route('shop.index')->withErrors(['cost' => "Need {$needed_coins} more coins to purchase"]);
        }

        return redirect()->route('shop.index');
    }

    public function equip(Cosmetic $cosmetic) {

        $gamestate = Gamestate::find(1);

        $gamestate->update(['current_background' => $cosmetic->asset]);

        return redirect()->route('options.index');
    }
}
