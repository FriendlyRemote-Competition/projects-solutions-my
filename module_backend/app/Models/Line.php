<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    public $table = 'lines';
    protected $guarded = [];

    public $primaryKey = 'code';
    public $keyType = 'string';

    public function getStationAAttribute()
    {
        $station = $this->station_a()->first();
        return $station->only("code","name");
    }
    public function getStationBAttribute()
    {
        $station = $this->station_b()->first();
        return $station->only("code","name");
    }
    public function getServiceWindowsAttribute()
    {
        $service_windows = $this->service_windows()->get();
        return $service_windows->map(function($window){
            return $window->only("start_time","end_time","interval_minutes");
        });
    }
    public function station_a()
    {
        return $this->belongsTo(Station::class, "station_a_code", "code");
    }

    public function station_b()
    {
        return $this->belongsTo(Station::class, "station_b_code", "code");
    }

    public function service_windows()
    {
        return $this->hasMany(ServiceWindow::class, "line_code", "code");
    }

    public function departures()
    {
        return $this->hasMany(Departure::class, "line_code", "code");
    }
}
