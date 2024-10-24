<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function locations()
    {
        return $this->belongsToMany('App\Models\Location')->withPivot('from','to','type','etype_id','status');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item')->withPivot('from','to','qty','status');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }
}
