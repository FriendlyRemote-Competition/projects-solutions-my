<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    public $table = "departures";
    protected $guarded = [];

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_code', 'code');
    }

    public function getOriginAttribute()
    {
        $line = $this->line()->first();
        return $line->station_a;
    }
    public function getDestinationAttribute()
    {
        $line = $this->line()->first();
        return $line->station_b;
    }

    public function getFareCnyAttribute()
    {
        $line = $this->line()->first();
        return $line->fare_cny;
    }
}
