<?php

namespace App\Http\Controllers\Api\Ads;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AdsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAdsController extends Controller
{

    public function createAds(AdsRequest $request){

        $validatedData=$request->validated();

        //Checking if the title is already in use with the same user
        $ad = Announcement::where('title', $request->title)
        ->where('user_id', Auth::guard('api')->user()->id)
        ->get();

        if($ad->count()){
             return response(['Titre','Vous avez déjà une annonce du même titre, ajoutez un emoji ou un mot pour varier'], 400)
                 ->header('Content-Type', 'application/json');
           

        }

        //Validation passed, processing with storage

        //Checking number format
        $array = str_split($request->phone);
        if($array[0] == 6){
            $phone = '237'.$request->phone;
        }
        elseif($array[0] == 2){
            $phone = $request->phone;
        }
        else{
            $phone = substr($request->phone,1) ;
        }

        $ads = new Announcement;
        $ads->user_id = Auth::guard('api')->user()->id;
        $ads->town_id = $request->town_id;
        $ads->quarter_id = $request->quarter_id;
        $ads->announcement_category_id = $request->category_id;
        $ads->accepted= $request->accepted;
        $ads->location = $request->location;
        $ads->slug=$this->slugify($request->title);
        $ads->title = $request->title;
        $ads->age = $request->age;
        $ads->gender = $request->gender;
        $ads->whatsapp = $phone;
        $ads->description = $request->description;
        $ads->expire=Carbon::now()->addDay(14);

        

        if($ads->save()){

            //Check if video is uploaded and save it

            if($request->file('video') != null){

        
                $video = $request->file('video');

                //Storing file in disk
                $fileName = $ads->id.'_'.time().'_'.$video->getClientOriginalName();
                $video->storeAs('public/ads/'.$ads->id.'/videos', $fileName);

                //Update path in ads tables
                $ads->video_path = $fileName;
                $ads->save();
            }

            return response($ads, 200)
                 ->header('Content-Type', 'application/json');
       }
       else{
           return response("{error:error}", 500)
                 ->header('Content-Type', 'application/json');
       }
    }

    function slugify($string, $delimiter = '-') {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }

    public function update(Request $request){

        $ad = Announcement::findOrFail($request->id);
        if(!$ad)
            return response('Ads not found', 400)
                  ->header('Content-Type', 'application/json');
        else{

            $ad->town_id = $request->town_id;
            $ad->quarter_id = $request->quarter_id;
            $ad->announcement_category_id = $request->category_id;
            $ad->accepted= $request->accepted;
            $ad->location = $request->location;
            $ad->title = $request->title;
            $ad->age = $request->age;
            $ad->gender = $request->gender;
            $ad->whatsapp = $request->phone;
            $ad->description = $request->description;
            $ad->save();
             return response($ad, 200)
                  ->header('Content-Type', 'application/json');
        }

    }

}
