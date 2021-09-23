<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image'];
    public function sub_categories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }
    public function products_limi3()
    {
        return $this->hasMany(Product::class, 'sub_category_id')->with('limit_images')
            ->with('images', 'brand:id,name', 'category:id,name', 'sub_category:id,name', 'offer');
    }
}
