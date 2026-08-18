<?php

namespace Database\Seeders;

use App\Models\CancelledDeparture;
use App\Models\Departure;
use App\Models\Line;
use App\Models\ServiceWindow;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $handle = fopen(base_path()."/data/admins.csv", "r");
        $headers = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            User::create([
                "email" => $data[0],
                "password" => Hash::make($data[1]),
                "name" => $data[2],
                "role" => $data[3],
                "is_active" => $data[4],
            ]);
        }

        $handle = fopen(base_path()."/data/stations.csv", "r");
        $headers = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            Station::create([
                "code" => $data[0],
                "name" => $data[1],
                "bank" => $data[2],
                "district" => $data[3],
                "address" => $data[4],
            ]);
        }

        $handle = fopen(base_path()."/data/lines.csv", "r");
        $headers = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            if(Line::find($data[0]))continue;
            Line::create([
                "code" => $data[0],
                "name" => $data[1],
                "status" => $data[2],
                "station_a_code" => $data[3],
                "station_b_code" => $data[5],
                "seat_capacity" => $data[7],
                "crossing_minutes" => $data[8],
                "fare_cny" => $data[9],
            ]);
        }

        $handle = fopen(base_path()."/data/lines.csv", "r");
        $headers = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            ServiceWindow::create([
                "line_code" => $data[0],
                "start_time" => $data[10],
                "end_time" => $data[11],
                "interval_minutes" => $data[12],
            ]);
        }

        $handle = fopen(base_path()."/data/cancelled_departures.csv", "r");
        $headers = fgetcsv($handle);
        while ($data = fgetcsv($handle)) {
            CancelledDeparture::create([
                "line_code" => $data[0],
                "departure_date" => $data[1],
                "departure_time" => $data[2],
                "departure_station_code" => $data[3],
                "reason" => $data[4],
                "cancelled_at" => $data[5],
            ]);
        }

        fclose($handle);

        Departure::create([
            "code" => "DJ-20260916-0600-DCL",
            "line_code" => "DJ",
            "departure_date" => "2020-09-16",
            "departure_time" => "06:00",
            "arrival_time" => "06:08",
            "seats_booked" => 46,
            "seats_available" => 2,
            "status" => "departed"
        ]);

        Departure::create([
            "code" => "DJ-20260916-0600-JLE",
            "line_code" => "DJ",
            "departure_date" => "2020-09-16",
            "departure_time" => "06:00",
            "arrival_time" => "06:08",
            "seats_booked" => 46,
            "seats_available" => 2,
            "status" => "departed"
        ]);
    }
}
