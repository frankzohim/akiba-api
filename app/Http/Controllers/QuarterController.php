<?php

namespace App\Http\Controllers;
use App\Http\Resources\QuarterResource;
use App\Http\Requests\QuarterRequest;
use Illuminate\Http\Request;
use App\Models\Quarter;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return QuarterResource::collection(Quarter::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuarterRequest $request)
    {
     
        $validatedData = $request->validated();

         $quarter = Quarter::create([
            'quarter_name' => $request->quarter_name,
            'town_id' => $request->town_id,

        ]);

        return new QuarterResource($quarter);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quarter $Quarter)
    {
        return new QuarterResource($Quarter);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quarter $quarter)
    {
         $quarter->update([
            'quarter_name' => $request->quarter_name,
            'town_id' => $request->town_id,
        ]);

         return new QuarterResource($quarter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quarter $quarter)
    {
        //Check if Quarter has ads
        $quarterR =  new QuarterResource($quarter);
        if($quarterR->ads()->count() > 0 )
            return response("Impossible de supprimer, ce quartier contient des annonces", 400);
        else{
            $quarter->delete();
        return response(null, 204);
        }    
    }
}
