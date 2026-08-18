<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceWorkerRequest;
use App\Models\Line;
use App\Models\ServiceWindow;
use Illuminate\Http\Request;

class ServiceWindowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(CreateServiceWorkerRequest $request, string $code)
    {
        $data = $request->validated();

        $line = Line::find($code);
        if(!$line)return $this->error404();

        $line->service_windows()->create($data);

        return response()->json([
            "start_time" => $data["start_time"],
            "end_time" => $data["end_time"],
            "interval_minutes" => $data["interval_minutes"]
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code, string $start_time)
    {
        $service_window = ServiceWindow::where('line_code', $code)
            ->where('start_time', '=', $start_time)
            ->first();
        if(!$service_window)return $this->error404();

        $service_window->delete();

        return response()->json([
            "message" => "Service window deleted."
        ],200);
    }
}
