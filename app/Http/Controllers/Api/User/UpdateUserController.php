<?php

namespace App\Http\Controllers\Api\User;
use App\Models\Town;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class UpdateUserController extends Controller
{
    public function updateUser(UpdateUserRequest $request){
        $input=$request->all();
        $user=User::find(Auth::guard('api')->user()->id);
        $update=$user->update($input);
        if($request->town_id){
            $user->town_id=$request->town_id;
            $user->save();
        }
        if($request->password){
            $user->password=Hash::make($request->password);
            $user->save();
        }
        return response()->json(['message'=>'User update'],200);
    }
}
