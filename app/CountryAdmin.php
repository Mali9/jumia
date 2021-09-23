<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryAdmin extends Model
{
    protected $table = 'country_admin';
    public  $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
