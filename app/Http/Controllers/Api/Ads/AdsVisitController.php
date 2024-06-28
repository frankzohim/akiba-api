<?php

namespace App\Http\Controllers\Api\Ads;

use App\Http\Controllers\Controller;
use App\Models\Announcement_visit;
use Illuminate\Http\Request;

class AdsVisitController extends Controller
{
    public function visit($id){
        $visits=Announcement_visit::where('announcement_id',$id)->count();

        return $visits;
    }
}
