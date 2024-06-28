<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListShapeResource;
use App\Models\Shape;
use Illuminate\Http\Request;

class ListShapeController extends Controller
{
    public function list(){

        $shape=ListShapeResource::collection(Shape::all());

        return $shape;
    }
}
