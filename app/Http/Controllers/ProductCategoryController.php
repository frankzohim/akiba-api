<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\Image;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductCategoryResource::collection(ProductCategory::all());
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
        //Validation passed, processing with storage
        $category = ProductCategory::create([
            'name' => $request->name,
            'slug' => $this->slugify($request->name),
            'state' => $request->state,
            'parent_id' => $request->parent
        ]);

        return new ProductCategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $category)
    {
        return new ProductCategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        //Check if category contains others categories

        // code here

        //Check if category contains products
        $category->delete();
        //Delete images folder
        \Illuminate\Support\Facades\Storage::deleteDirectory('public/categories/'.$category->id);
        return response(null, 204);
    }

    public function uploadLogo(Request $request){

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->category_id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/categories/'.$request->category_id, $fileName);

            //Add image to database (categories_images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->categories()->attach($request->category_id);


            return response($image, 200)
                  ->header('Content-Type', 'application/json');
         
    }

 

    public function categoryImage($id, $path)
    {
        $imageDisplay = Image::find($path);
        return response()->download(storage_path('app/public/categories/'.$id.'/'.$imageDisplay->path));
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
}
