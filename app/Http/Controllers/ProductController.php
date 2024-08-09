<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Display a listing of the resource.
     */
    public function productStore($storeId)
    {
        //return $storeId;
        return ProductResource::collection(Product::where('store_id', $storeId)->get());
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
        $product = Product::create([
            'name' => $request->name,
            'reference' => $request->reference,
            'slug' => $this->slugify($request->name),
            'product_category_id' => $request->category,
            'brand_id' => $request->brand,
            'store_id' => $request->store,
            'sku' => $request->sku,
            'summary' => $request->summary,
            'description' => $request->description,
            'price' => $request->price,
            'sale_quantity' => $request->sale_quantity,
            'stock_quantity' => $request->stock,
            'video' => $request->video,
            'state' => $request->state
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        //Deleting product image
        foreach($product->images as $image){
            $img = Image::find($image['id']);
            $img->delete();
        }

        //Check if category contains products
        $product->delete();
        //Delete images folder
        \Illuminate\Support\Facades\Storage::deleteDirectory('public/products/'.$product->id);
        return response(null, 204);
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

    public function uploadImages(Request $request){

            //Validation passed, processing with storage

            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            $allowedfileExtension=['jpg','png','jpeg'];

            $check = in_array($extension,$allowedfileExtension);

            //Storing file in disk
            $fileName = $request->product_id.'_'.time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/products/'.$request->product_id, $fileName);

            //Add image to database (categories_images table)
            $image = new \App\Models\Image;
            $image->path = $fileName;
            $image->save();
            $image->products()->attach($request->product_id);


            return response($image, 200)
                  ->header('Content-Type', 'application/json');
         
    }

    public function productImage($id, $path)
    {
        $imageDisplay = Image::find($path);
        return response()->download(storage_path('app/public/products/'.$id.'/'.$imageDisplay->path));
    }
}
