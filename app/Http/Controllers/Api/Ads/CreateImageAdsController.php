<?php

namespace App\Http\Controllers\Api\Ads;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementImage;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CreateImageAdsController extends Controller
{

    public function createImages(ImageRequest $request){
       

        $validatedData=$request->validated();

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->ads_id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/ads/'.$request->ads_id, $fileName);

            //Add image to database (product_images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->ads()->attach($request->ads_id);


            return response($image, 200)
                  ->header('Content-Type', 'application/json');
         
    }

     public function delete($id){

        $image = Image::findOrFail($id);
        if(!$image)
            return response('Image not found', 400)
                  ->header('Content-Type', 'application/json');
        else{
            $image->delete();
             return response("Image delete successfully", 200)
                  ->header('Content-Type', 'application/json');
        }
       
      
    }
}
