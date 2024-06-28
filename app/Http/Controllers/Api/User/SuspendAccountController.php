<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuspendAccountController extends Controller
{
    public function ban($id){
        $user = User::find($id);
        $user->ban();

        return response()->json(['code'=>200,'message'=>"Suspend account successfully"],200);
    }
}
