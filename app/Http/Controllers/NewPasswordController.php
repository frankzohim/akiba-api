<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use App\Models\User;

class NewPasswordController extends Controller
{
   public function Newpassword (Request $request){

    $passwordReset = ResetCodePassword::firstWhere('code', $request->code);
    $user = User::where('email','=',$passwordReset->email)->first();

    if($request->code==$passwordReset->code && $user->email==$passwordReset->email){
        // update user password
         $password=bcrypt($request->password);
         $user->password=$password;
         $user->save();

         // delete current code
         $passwordReset->delete();

         return response(['message' =>'mot de passe reinitialisé avec success'], 200);
     }
     if($request->code!=$passwordReset->code ){

        return response(['message' => "le Code de reinitialisation de votre mot de passe est invalide"],404);
    }

   }
}
