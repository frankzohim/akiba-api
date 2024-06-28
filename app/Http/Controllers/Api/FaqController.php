<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs=Faq::all();

        return $faqs;
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
    public function store(Request $request)
    {
        $faq=new Faq;
        $faq->questions=$request->questions;
        $faq->answer=$request->answer;
        $faq->save();

        return response()->json(['message'=>'faq created successfully'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq=Faq::find($id);

        return $faq;
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
    public function update(Request $request, string $id)
    {
        $faq=Faq::find($id);
         $faq->questions=$request->questions;
        $faq->answer=$request->answer;
        $faq->save();

        return response()->json(['message'=>'faq updated successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq=Faq::find($id);
        $faq->delete();

        return response()->json(['message'=>"faq deleted successfully"],200);
    }

    public function faqs(){

        $faqs=Faq::all();

        return $faqs;
    }
}
