<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->get();

        return view( 'admin.products.index', compact('products'));
    }

}
