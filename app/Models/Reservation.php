<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function locations()
    {
        return $this->belongsToMany('App\Models\Location');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item');
    }
}
