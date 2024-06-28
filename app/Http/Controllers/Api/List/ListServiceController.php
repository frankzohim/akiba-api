<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ListServiceController extends Controller
{
    public function list(){
        $list=ListServiceResource::collection(Service::all());

        return $list;
    }
}
