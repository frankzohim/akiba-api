<?php

namespace App\Http\Controllers\Api\Report;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Announcement;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReportResource::collection(Report::all());
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
    public function store(ReportRequest $request)
    {
        $image = $request->file('myfile');

        //Storing file in disk
        $fileName = $request->id.'_'.time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/report/'.$request->id, $fileName);

        $validatedData=$request->validated();
        $report = Report::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'message' => $request->message,
            'path' => $fileName,
            'status' => 0,
        ]);

        $report->ads()->attach($request->id);

        return new ReportResource($report);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return new ReportResource($report);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
         $report->update([
            'status' => $request->status,
        ]);

         return new ReportResource($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return response(null, 204);
    }

    /***
     * Display report
     */
    public function displayReportImage($id, $adsId)
    {
       $report = Report::find($id);
       $ads = Announcement::find($adsId);
       //return $ads;
       return response()->download(storage_path('app\public\report\\'.$ads->id.'\\'.$report->path));

    }
}
