<?php

namespace App\Http\Controllers;
use App\Models\Escort;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class LocationController extends Controller
{
    public function index(){

        try{

                //Retrieving all towns
                $locations = Town::all();

                //Loop into the collections with map method
                $locations = $locations->map(function($town){
                
                    $quarters = Town::find($town->id)->quarters()->get();
                    $quartersIn = [];
                    $i = 0;
                    foreach($quarters as $quarter){
                        $quartersIn[$i++] = $quarter->id;
                    }

                    //Getting escorts by quarter
                    $locals =  DB::table('escorts')
                            ->join('quarters', 'quarters.id', '=','escorts.quarter_id')
                            ->select('quarter_name','quarter_id', DB::raw('count(*) as total'))
                            ->whereIn('quarter_id', $quartersIn)
                            ->groupBy('quarter_name')
                            ->get();

                    //Getting escort by town
                    $sum = 0;
                    foreach($locals as $local){
                        $sum += $local->total;
                    }

                    $town['numberEscort'] = $sum;
                    $town['locals'] = $locals;
                            return $town;

                })->reject(function($town){ //Removing all towns with no escorts
                    return $town->locals->count() == 0;
                });

                return response($locations, 200)
                  ->header('Content-Type', 'application/json');
        
        }

        catch(e){
            return response("{error:Unable to fetch location}", 500)
                  ->header('Content-Type', 'application/json');
        }
        
    }
}
