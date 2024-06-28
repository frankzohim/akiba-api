<?php

namespace App\Http\Controllers\Api;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnnounceResource;

class FilterAdsController extends Controller
{
    public function filter(Request $request){

        $results=AnnounceResource::collection(Announcement::where('quarter_id','=',$request->quarter)
        ->where('subscribe_id','=',$request->subscribe_id)

        ->where('status',1)
        ->get());
        return response()->json(['data'=> $results],200);
    }
}
