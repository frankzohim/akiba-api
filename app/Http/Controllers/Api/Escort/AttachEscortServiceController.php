<?php

namespace App\Http\Controllers\Api\Escort;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Escort\AddServicesRepository;
use Exception;

class AttachEscortServiceController extends Controller
{
    public function attach(Request $request){

            try{
                $newServices=(new AddServicesRepository())->addServices($request->service,$request->escort);
            return $newServices;
            }catch(Exception $e){
                dd($e->getMessage());
            }


    }
}
