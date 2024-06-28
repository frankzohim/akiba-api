<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use App\Http\Requests\CheckEmailRequest;

class CheckEmailController extends Controller
{
    public function Checkemail (Request $request){
        $valid = validator($request->only('email'), [
            'email' => 'required|string|exists:users,email',
        ]);
        if ($valid->fails()) {
            return response()->json(['error'=>$valid->errors()], 400);
        }
        
        ResetCodePassword::where('email', $request->email)->delete();

       
        $data['code'] = mt_rand(100000, 999999);

        $codeData = ResetCodePassword::create(['email'=>$request->email, 'code'=>$data['code']]);
        $message="Votre numéro de reinitialisation de mot de passe est ".$data['code'];
        return response(['message' => "Un numéro de reinitialisation vous a été envoyé à votre addresse Email"], 200);
    }
}
