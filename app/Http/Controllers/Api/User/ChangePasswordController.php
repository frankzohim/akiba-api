<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function resetPassword(Request $request){
        $user=User::where('phone_number',$request->phone_number)->first();
        $user->password=$request->password;
        $user->save();

        return response()->json(['reset'=>true,'message'=>"reset password successfully"],200);
    }
}
