<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListQuaterByTownResource;
use App\Models\Quarter;
use Illuminate\Http\Request;

class ListQuaterByTownController extends Controller
{
    public function list($id){
        $listQuarter=ListQuaterByTownResource::collection(Quarter::where('town_id',$id)->get());
        return $listQuarter;
    }
}
