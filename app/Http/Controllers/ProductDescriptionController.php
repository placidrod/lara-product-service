<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Description;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        return Description::ofProduct($productId)->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($productId, Request $request)
    {
        $product = Product::findOrFail($productId);

        $product->descriptions()->save(new Description([
            'body' => $request->input('body')
        ]));

        return $product->descriptions;
        // return Description::create([
        //     'product_id'    => $productId,
        // ]);
    }
    
}
