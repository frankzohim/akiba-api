<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GiveCreditUserController extends Controller
{
    public function giveCredit(Request $request,$user_id){
        $user=User::find($user_id);
        $user->balance=$user->balance+$request->balance;
        $user->save();

        return response()->json('credit added successfully');
    }
}
