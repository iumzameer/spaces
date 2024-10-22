<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function tiers()
    {
        return $this->belongsToMany('App\Models\Tier', 'rates', 'il_id', 'tier_id')->withPivot('type','amount')->wherePivot('type', 'item');
    }
}
