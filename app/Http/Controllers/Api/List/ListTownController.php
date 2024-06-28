<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListTownResource;
use App\Models\Town;
use Illuminate\Http\Request;

class ListTownController extends Controller
{
    public function list(){
        $towns=ListTownResource::collection(Town::all());

        return $towns;
    }
}
