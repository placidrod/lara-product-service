<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable = ['product_id', 'body'];

    public function product()
    {
    	// $this->belongsTo(Product::class);
    	$this->belongsTo('App\Product');
    }

    public function scopeOfProduct($query, $productId)
    {
    	return $query->where('product_id', $productId);
    }
}
