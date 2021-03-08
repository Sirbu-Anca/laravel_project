<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('javascript');
    }

    public function getProducts()
    {
        if (count(session()->get('cart', []))) {
            $cartIds = array_values(session()->get('cart'));
            $products = Product::query()
                ->whereNotIn('id', $cartIds)
                ->paginate(5);
        } else {
            $products = Product::query()
                ->paginate(5);
        }
        return response()->json($products);
    }

}
