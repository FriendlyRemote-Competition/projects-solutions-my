<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelBookingRequest;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\LookupBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Departure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $query = Booking::query();
        $page = $request->query('page',1);
        $limit = 15;

        if(!empty($status)) {
            $query->where("status", $status);
        }

        if(!empty($search)) {
            $query->orWhere("booking_code", "like", "%$search%");
            $query->orWhere("first_name", "like", "%$search%");
            $query->orWhere("last_name", "like", "%$search%");
            $query->orWhere("email", "like", "%$search%");
        }

        $bookings = (clone $query)->skip(($page - 1) * $limit)->limit(10)->get();


        return $this->success200Meta($bookings->map(function ($booking) {
            return $booking->only(
                "booking_code", "status", "first_name", "last_name",
                "email", "phone", "seats", "fare_cny", "total_fare_cny",
                "departure_code", "created_at", "updated_at",
                "cancelled_at"
            );
        }),[
            "current_page" => 1,
            "last_page" => 1,
            "per_page" => $limit,
            "total" => $query->count(),
        ]);
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
    public function store(CreateBookingRequest $request)
    {
        $data = $request->validated();

        $departure = Departure::where("code",$data['departure_code'])->first();
        if(!$departure)return $this->error404();

        if($departure->seats_available < $data['seats'])return $this->error422Bis("Not enough seats available");

        $line = $departure->line()->first();
        $total_fare_cny = number_format($data['seats'] * $line->fare_cny, 2);

        $departure->update([
            "seats_available" => $departure->seats_available - $data['seats'],
            "seats_booked" => $departure->seats_booked + $data['seats'],
        ]);

        $booking = Booking::create([
            "booking_code" => "HPF-".strtoupper(Str::random(6)),
            "status" => "confirmed",
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "seats" => $data['seats'],
            "fare_cny" => $line->fare_cny,
            "total_fare_cny" => $total_fare_cny,
            "departure_code" => $departure->code,
        ]);

        return $this->success201($booking->only(
            "booking_code", "status", "first_name", "last_name",
            "email", "phone", "seats", "fare_cny", "total_fare_cny",
            "departure_code", "created_at", "updated_at",
            "cancelled_at"
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(LookupBookingRequest $request)
    {
        $data = $request->validated();
        $booking = Booking::where("booking_code", $data['booking_code'])
            ->orWhere("first_name", $data['first_name'])
            ->orWhere("last_name", $data['last_name'])
            ->first();

        if(!$booking)return $this->error404();

        return $this->success200($booking->only(
            "booking_code", "status", "first_name", "last_name",
            "email", "phone", "seats", "fare_cny", "total_fare_cny",
            "departure_code", "created_at", "updated_at",
            "cancelled_at"
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $code)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, string $code)
    {
        $data = $request->validated();
        $booking = Booking::where("booking_code", $code)
            ->orWhere("first_name", $data['first_name'])
            ->orWhere("last_name", $data['last_name'])
            ->first();

        if($booking->status != 'confirmed')return $this->error422Bis("Booking is already cancelled");

        $departure = Departure::where("code", $booking->departure_code)->first();

        $seatsLeft = $departure->seats_available + $booking->seats;
        $seatsBooked = $departure->seats_booked - $booking->seats;
        if($seatsLeft < $data['seats'])return $this->error422Bis("Not enough seats available");

        $booking->update([
            "seats" => $data['seats'],
            "total_fare_cny" => number_format($booking->fare_cny * $data['seats'],2),
        ]);
        $departure->update([
           "seats_available" => $seatsLeft - $data['seats'],
           "seats_booked" => $seatsBooked + $data['seats'],
        ]);

        return $this->success200($booking->only(
            "booking_code", "status", "first_name", "last_name",
            "email", "phone", "seats", "fare_cny", "total_fare_cny",
            "departure_code", "created_at", "updated_at",
            "cancelled_at"
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CancelBookingRequest $request, string $code)
    {
        $data = $request->validated();
        $booking = Booking::where("booking_code", $code)
            ->orWhere("first_name", $data['first_name'])
            ->orWhere("last_name", $data['last_name'])
            ->first();

        if($booking->status != 'confirmed')return $this->error422Bis("Booking is already cancelled");
        $booking->update([
            "status" => "cancelled",
            "cancelled_at" => date("Y-m-d H:i:s"),
        ]);

        $departure = Departure::where("code", $booking->departure_code)->first();

        $departure->update([
           'seats_available' => $departure->seats_available + $booking->seats,
            'seats_booked' => $departure->seats_booked - $booking->seats,
        ]);

        return $this->success200($booking->only(
            "booking_code", "status", "first_name", "last_name",
            "email", "phone", "seats", "fare_cny", "total_fare_cny",
            "departure_code", "created_at", "updated_at",
            "cancelled_at"
        ));
    }
}
