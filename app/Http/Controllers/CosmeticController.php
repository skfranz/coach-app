<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cosmetic;
use App\Models\User;

class CosmeticController extends Controller
{
    public function buy(Cosmetic $cosmetic) {

        $user = User::find(1); // When multiple users are implemented, use user->auth()
        
        if ($user->total_coins >= $cosmetic->price) {
            $user->update(['total_coins' => $user->total_coins -= $cosmetic->price]);
            $cosmetic->update(['purchased_status' => true]);
            $user->update(['current_background' => $cosmetic->name]);
        }

        return redirect()->route('shop.index');
    }
}
