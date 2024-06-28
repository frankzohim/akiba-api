<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class VerifyQuestionController extends Controller
{
    public function verify(Request $request){

        $user=User::where('phone_number',$request->phone_number)->first();
        $isSecure=$user->isSecure ?? null;

        if($isSecure==0 && isset($user)){
            return response()->json(["error"=>500,"message"=>"You don't have yet securise your account"],500);
        }else if(empty($user)){
            return response()->json(["error"=>404,"message"=>"Account not found"],404);
        }

        else{
            $questions=$user->questions;
            return response()->json(['questions'=>$questions],200);
        }

    }
}
