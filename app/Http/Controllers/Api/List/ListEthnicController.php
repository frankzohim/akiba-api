<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListEthnicResource;
use App\Models\Ethnic;
use Illuminate\Http\Request;

class ListEthnicController extends Controller
{
    public function list(){
        $ethnics=ListEthnicResource::collection(Ethnic::all());

        return $ethnics;
    }
}
