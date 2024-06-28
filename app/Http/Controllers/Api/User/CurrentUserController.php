<?php

namespace App\Http\Controllers\Api\User;
use App\Models\Town;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
class CurrentUserController extends Controller
{
    public function currentUser(){
        $User=Auth::guard('api')->user();
        //$User->town = Town::find($User->town_id);
        return $User;
    }
}
