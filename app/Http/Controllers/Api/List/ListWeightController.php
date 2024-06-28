<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListWeightResource;
use App\Models\Weight;
use Illuminate\Http\Request;

class ListWeightController extends Controller
{
    public function list(){
        $weight=ListWeightResource::collection(Weight::all());

        return $weight;
    }
}
