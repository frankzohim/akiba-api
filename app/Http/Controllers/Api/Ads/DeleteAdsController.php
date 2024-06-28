<?php

namespace App\Http\Controllers\Api\Ads;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\AdsRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;

class DeleteAdsController extends Controller
{

    public function delete($id){

          
        $ad = Announcement::findOrFail($id);
        if(!$ad)
            return response('Ads not found', 400)
                  ->header('Content-Type', 'application/json');
        else{
            //Deleting ads's image
            $images = $ad->images()->getResults();
            foreach($images as $image){
                Image::find($image['id'])->delete();
            }
            //Deleting ads's directory
          
            \Illuminate\Support\Facades\Storage::deleteDirectory('public/ads/'.$ad->id);
            $ad->delete();
             return response("Ads delete successfully", 200)
                  ->header('Content-Type', 'application/json');
        }
       
      
    }

}
