<?php

namespace App\Http\Controllers\Api\Search;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Town;
use App\Models\Quarter;
use App\Models\User;
use App\Models\Announcement;

class ResearchController extends Controller
{
    public function search($term){

      // $searchResults = (new Search())
      //   ->registerModel(Announcement::class, 'title')
      //   ->search($term);

      $searchResults = (new Search())
        ->registerModel(Announcement::class, function(ModelSearchAspect $modelSearchAspect) {
            $modelSearchAspect
                ->addSearchableAttribute('title')
                ->with('User')
                ->orderBy('subscribe_id','DESC')
                ->where('status',1)
                ->with('town')
                ->with('images');

      })

      ->registerModel(User::class, function(ModelSearchAspect $modelSearchAspect) {
            $modelSearchAspect
                ->addSearchableAttribute('username')
                ->with('ads');
      })

      ->registerModel(Town::class, 'town_name')
      ->registerModel(Quarter::class, 'quarter_name')
      ->search($term);


       return response(json_encode($searchResults), 200)
                  ->header('Content-Type', 'application/json');
    }


}
