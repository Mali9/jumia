<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryRep extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
