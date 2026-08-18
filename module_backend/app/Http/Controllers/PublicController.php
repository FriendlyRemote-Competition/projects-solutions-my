<?php

namespace App\Http\Controllers;

use App\Models\Departure;
use App\Models\Station;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function board()
    {
        $stations = Station::all()->sortBy('code');

        return view('board', compact('stations'));
    }

    public function departureScreen(string $stationCode)
    {
        $departures = Departure::all();
//        dd($departures);
        return view('departure', compact('departures'));
    }
}
