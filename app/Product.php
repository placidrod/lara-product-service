<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['name'];

    public function descriptions()
    {
    	// return $this->hasMany(Description::class);
    	return $this->hasMany('App\Description');
    }
}
