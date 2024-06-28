<?php

namespace App\Http\Controllers;
use App\Http\Resources\BannerResource;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BannerResource::collection(Banners::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $image = $request->myfile;

            //Storing file in disk
            $fileName = $request->id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/banners/'.$request->id, $fileName);
            $banner = Banners::find($request->id);

             $banner->update([
            'status' => $request->status,
            'path' => $fileName,
          ]);
         
        return 'in store';
         return new BannerResource($banner);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banners $banner)
    {
        return new BannerResource($banner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banners $banner)
    {

            
            if($request->status == 1){
                //check if the path is ok
                
                $src = storage_path('app\public\banners\\'.$banner->id.'\\'. $banner->path);
                
                if (!file_exists($src)) {
                    $status = 0;
                }
                else
                
                    $status = $request->status;
                    $banner->update([
                    'status' => $status,
                ]);
            }

            else{
               
                    $banner->update([
                    'status' => 0,]);
            }
           

         return new BannerResource($banner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function displayBanner($id)
    {
        $banner = Banners::find($id);
        //return $banner;
        return response()->download(storage_path('app\public\banners\\'.$id.'\\'. $banner->path));
    }
}
