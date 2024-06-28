<?php

namespace App\Http\Controllers\Api\Escort;
use App\Http\Resources\EscortResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Escort;
use Illuminate\Support\Facades\Auth;

class GetEscortController extends Controller
{
    public function getEscort(){
        $user=Auth::guard('api')->user()->id;
        $escort=Escort::where('user_id',$user)->first();
        return response(new EscortResource($escort), 200)
                  ->header('Content-Type', 'application/json');


    }
}
