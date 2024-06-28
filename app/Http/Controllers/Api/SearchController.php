<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function resultEscortCount($term){
        $results=DB::table('escorts')
                ->join('users','escorts.user_id','=','users.id')
                ->join('quarters','quarters.id','escorts.quarter_id')
                ->join('shapes','shapes.id','escorts.shape_id')
                ->join('skin_colors','skin_colors.id','escorts.skin_color_id')
                ->join('ethnics','ethnics.id','escorts.ethnic_id')
                ->select('escorts.id','escorts.escort_name','ethnics.ethnic_name','skin_colors.skin_color_name','shapes.shape_name','quarters.quarter_name','escorts.description')
                ->orWhere('escorts.escort_name','like',"%$term%")
                ->orWhere('escorts.description','like',"%$term%")
                ->orWhere('shapes.shape_name','like',"%$term%")
                ->orWhere('ethnics.ethnic_name','like',"%$term%")
                ->orWhere('skin_colors.skin_color_name','like',"%$term%")
                ->orWhere('quarters.quarter_name','like',"%$term%")
                ->count();

                return response()->json(['result'=> $results],200);
    }

    public function resultAdsCount($term){

    }
}
