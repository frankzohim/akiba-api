<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
        $brand->delete();
        return response(null, 204);
    }
}
