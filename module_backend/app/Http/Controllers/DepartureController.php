<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelDepartureRequest;
use App\Models\Booking;
use App\Models\Departure;
use Illuminate\Http\Request;

class DepartureController extends Controller
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
    public function store(Request $request)
    {
        //
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
    public function destroy(CancelDepartureRequest $request, string $code)
    {
        $departure = Departure::where('code', $code)->first();
        if(!$departure)return $this->error404();
        if($departure->status === "cancelled")return $this->error422Bis("Departure is already cancelled");

        $departure->status = "cancelled";
        $departure->save();

        $bookings = Booking::where('departure_code', $code)->get();
        foreach($bookings as $booking){
            $booking->cancelled_at = date("Y-m-d H:i:s",strtotime("now"));
            $booking->save();
        }

        return $this->success200(["affected_bookings" => $bookings->count()]);
    }
}
