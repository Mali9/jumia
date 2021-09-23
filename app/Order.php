<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id')->with('product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id')
        ->with('city', 'country');
    }
}
