<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivateAccountController extends Controller
{
    public function activate($id){
        $user = User::find($id);
        $user->activate();
        
        return response()->json(['code'=>100,'message'=>"Account Activate successfully"],200);
    }
}
