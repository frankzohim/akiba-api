<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListHeightResource;
use App\Models\Height;
use Illuminate\Http\Request;

class ListHeightController extends Controller
{
    public function list(){
        $height=ListHeightResource::collection(Height::all());

        return $height;
    }
}
