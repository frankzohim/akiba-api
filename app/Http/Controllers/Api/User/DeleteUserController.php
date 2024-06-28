<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Image;

class DeleteUserController extends Controller
{
    public function delete($id){

        //Find the user
        $user = User::find($id);
        if($user){

            //Delete all user's ads
            $ads = $user->ads()->getResults();
          
            foreach($ads as $ad){

                $ad = Announcement::findOrFail($ad->id);
                if($ad){
                    //Deleting ads's image
                    $images = $ad->images()->getResults();
                    foreach($images as $image){
                        Image::find($image['id'])->delete();
                    }
                    //Deleting ads's directory
                
                    \Illuminate\Support\Facades\Storage::deleteDirectory('public/ads/'.$ad->id);
                    $ad->delete();
                    
                }

            }

            //deleting user
            $user->delete();

            return response("User delete successfully", 200)
                  ->header('Content-Type', 'application/json');            

        }

        else{
            return response()->json(['code'=>404,'message'=>"User not found"],404);
        }
      
        // $user = User::find($id);
        // $user->ban();

        // return response()->json(['code'=>200,'message'=>"Suspend account successfully"],200);
    }
}
