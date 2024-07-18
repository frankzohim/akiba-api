<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BrandResource::collection(Brand::all());
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
    public function store(StoreBrandRequest $request)
    {
        //Validate data

        $validatedData = $request->validated();

        //Validation passed, processing with storage
        $brand = Brand::create([
            'name' => $request->name,
            'state' => $request->state
        ]);

        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        //Validate data

        $validatedData = $request->validated();
        //Validation passed, processing with update
        $brand->update([
            'name' => $request->name,
            'state' => $request->state
        ]) ;

        return new BrandResource($brand);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        
        //Check if category contains products
        
        // code here
        $brand->delete();
        //Delete images folder
        \Illuminate\Support\Facades\Storage::deleteDirectory('public/brands/'.$brand->id);
        return response(null, 204);
    }

 
    public function uploadLogo(Request $request){
       

     

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->brand_id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/brands/'.$request->brand_id, $fileName);

            //Add image to database (brand_images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->brands()->attach($request->brand_id);


            return response($image, 200)
                  ->header('Content-Type', 'application/json');
         
    }
}
