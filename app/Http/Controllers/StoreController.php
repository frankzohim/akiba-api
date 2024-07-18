<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Illuminate\Http\Request;
use App\Http\Resources\StoreResource;
use App\Models\Image;
use App\Models\User;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StoreResource::collection(Store::all());
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
    public function store(StoreStoreRequest $request)
    {
        //Validation passed, processing with storage
        $store = Store::create([
            'name' => $request->name,
            'slug' => $this->slugify($request->name),
            'email' => $request->email,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'state' => $request->state,
            'user_id' => $request->user_id
        ]);

        return new StoreResource($store);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return new StoreResource($store);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {

        //Check if store contains products
        //Delete products if existed
        //Then delete store
        $store->delete();
        //Delete images folder
        \Illuminate\Support\Facades\Storage::deleteDirectory('public/stores/'.$store->id);
        return response(null, 204);
    }

    public function uploadImages(Request $request){

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->store_id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/stores/'.$request->store_id, $fileName);

            //Add image to database (stores_images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->stores()->attach($request->store_id);


            return response($image, 200)
                  ->header('Content-Type', 'application/json');
         
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

    public function vendorStores($userId){

        return StoreResource::collection(Store::where('user_id', '=', $userId)->get());
    }
}
