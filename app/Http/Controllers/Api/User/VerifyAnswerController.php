<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyAnswerController extends Controller
{
    public function verifyAnswer(Request $request){

        $user=User::where('phone_number',$request->phone_number)->first();
        $questions=$user->questions;
        foreach($questions as $question){
            if($question->id==$request->question_id){
                 if($question->pivot->answer==$request->answer){
                     return response()->json(['code'=>1],200);
                 }else{
                    return response()->json(['code'=>0],500);
                 }
            }
         }
    }
}
