<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\VerifyRequest;
use App\Http\Controllers\Controller;
use Exception;

class VerifyEscortController extends Controller
{
    public function verifyEscort(VerifyRequest $request){
            $request->validated();
            $user = User::find($request->id);
            $user->isVerify = ($user->isVerify == 1 ) ? 0 : 1;
            $user->save();
            return $user;
    }
}
