<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;

class NewUserController extends Controller
{
    public function newUser(UserRequest $userRequest){

        try{
            $user = new User;
            $user->username = $userRequest->username;
            if(isset($userRequest->email)){
                $user->email = $userRequest->email;
            }

            $user->role_id = $userRequest->role_id;
            $user->phone_number = $userRequest->phone_number;
            $user->password = Hash::make($userRequest->password);

            if($user->save()){
                return response()->json(['status'=>200,'user'=>$user],200);
            }
        }catch(Exception $e){
 return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'errors' => $e
              ], 500);
        }

    }
}
