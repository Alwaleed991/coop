<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::where('status', 'pending')
            ->with(['user', 'reportable.user'])
            ->get();

        return ReportResource::collection($reports);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $userId = $request->user()->id;
        $attribute = $request->validated();
        $attribute['user_id'] = $userId;
        $attribute['status'] = 'pending';
        $type = $attribute['reportable_type'];
        if ($type === "Post") {
            $attribute['reportable_type'] = "App\Models\Post";
        } else {
            $attribute['reportable_type'] = "App\Models\Comment";
        }

        $report = Report::create($attribute);

        return response()->json([
            'message' => 'Report has been received successfully',
            'data' => new ReportResource($report),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
