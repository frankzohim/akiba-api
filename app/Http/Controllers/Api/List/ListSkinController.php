<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListSkinColorResource;
use App\Models\Skin_color;
use Illuminate\Http\Request;

class ListSkinController extends Controller
{
    public function list(){
        $skinColor=ListSkinColorResource::collection(Skin_color::all());

        return $skinColor;
    }
}
