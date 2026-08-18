<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLineRequest;
use App\Http\Requests\UpdateLineRequest;
use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lines = Line::all();

        return $this->success200($lines->map(function ($line) {
            return $line->only(
                "code", "name", "status", "station_a", "station_b",
                "seat_capacity", "crossing_minutes", "fare_cny", "service_windows"
            );
        }));
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
    public function store(CreateLineRequest $request)
    {
        $data = $request->validated();

        $line = Line::create([
           "code" => $data["code"],
            "name" => $data["name"],
            "status" => $data["status"],
            "station_a_code" => $data["station_a_code"],
            "station_b_code" => $data["station_b_code"],
            "seat_capacity" => $data["seat_capacity"],
            "crossing_minutes" => $data["crossing_minutes"],
            "fare_cny" => $data["fare_cny"],
        ]);

        return $this->success201($line->only(
            "code", "name", "status", "station_a", "station_b",
            "seat_capacity", "crossing_minutes", "fare_cny", "service_windows"
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $line = Line::find($code);
        if(!$line)return $this->error404();

        return $this->success200($line->only(
            "code", "name", "status", "station_a", "station_b",
            "seat_capacity", "crossing_minutes", "fare_cny", "service_windows"
        ));
    }

    public function showTimetable(Request $request, string $code)
    {
        $line = Line::find($code);
        if(!$line)return $this->error404();

        $departures = $line->departures()->get();

        return $this->success200($departures->map(function ($departure) {
            return $departure->only(
                "code", "origin", "destination", "departure_date", "departure_time",
                "arrival_time", "seats_booked", "seats_available", "fare_cny",
                "status", "cancellation_reason"
            );
        }));
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
    public function update(UpdateLineRequest $request, string $code)
    {
        $line = Line::find($code);
        if(!$line)return $this->error404();

        $data = $request->validated();

        $line->update([
           "name" => $data["name"],
           "status" => $data["status"],
           "station_a_code" => $data["station_a_code"],
           "station_b_code" => $data["station_b_code"],
           "seat_capacity" => $data["seat_capacity"],
           "crossing_minutes" => $data["crossing_minutes"],
           "fare_cny" => $data["fare_cny"],
        ]);

        return $this->success200($line->only(
            "code", "name", "status", "station_a", "station_b",
            "seat_capacity", "crossing_minutes", "fare_cny", "service_windows"
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
