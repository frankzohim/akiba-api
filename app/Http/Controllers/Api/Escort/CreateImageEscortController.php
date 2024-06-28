<?php

namespace App\Http\Controllers\Api\Escort;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementImage;
use Illuminate\Http\Request;
use App\Models\Escort;
use App\Http\Requests\ImageRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class CreateImageEscortController extends Controller
{

    public function createImages(ImageRequest $request){
       

        $validatedData=$request->validated();

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->escort_id.'_'.$image->getClientOriginalName();
            $image->storeAs('public/escorts/'.$request->escort_id, $fileName);

            //Add image to database (images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->escort()->attach($request->escort_id);
            if($request->index==='1'){
                //Save profile photo
                $escort = Escort::find($request->escort_id);
                $escort->photo = $fileName;
                $escort->save();
            }


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
