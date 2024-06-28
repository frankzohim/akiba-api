<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetCodePassword;

class VerifyCodeController extends Controller
{
    public function Verifycode(Request $request){
        $valid = validator($request -> only('code'), [
            'code' => 'required|string|exists:reset_code_passwords,code',
        ] );
        if ($valid->fails()) {
            return response()->json(['error'=>$valid->errors()], 400);
        }
       $getcode=ResetCodePassword::where('code', $request->code)->first();

       if($request->code == $getcode->code){
        return response()->json(['code'=> $request->code]);
       } 
       else {
        return response()->json('Votre code nest pas valide');
       }


        return $getcode;
    }
}
