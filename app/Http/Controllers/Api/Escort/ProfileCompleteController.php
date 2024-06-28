<?php

namespace App\Http\Controllers\Api\Escort;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileCompleteRequest;
use App\Services\Escort\ProfileCompleteService;
use Illuminate\Http\Request;

class ProfileCompleteController extends Controller
{
    public function addProfile(ProfileCompleteRequest $request){

        try{
            $profileCompleteService=(new ProfileCompleteService())->addProfile($request);
            return $profileCompleteService;
            //return response()->json(["message"=>"Profile escort complete successfully","completed"=>1,"escort"=>$profileCompleteService],201);
        }catch(\Exception $e){
           return $e->getMessage();
        }
    }
}
