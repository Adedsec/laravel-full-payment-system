<?php

namespace App\Http\Controllers;

use App\Product;
use App\Support\Basket\Basket;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }
}
