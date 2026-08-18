<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public $table = 'stations';
    protected $guarded = [];

    public $primaryKey = 'code';
    public $keyType = 'string';
}
