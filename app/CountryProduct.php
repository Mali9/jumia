<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryProduct extends Model
{
    protected $table = 'country_products';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
