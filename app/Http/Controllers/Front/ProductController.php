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
        $products = Product::query()->get();
        if (count(session()->get('cart', []))) {
            $cartIds = array_values(session()->get('cart'));
            $products = Product::query()
                ->whereNotIn('id', $cartIds)
                ->get();
        }
        return view('front.index', compact('products'));
    }
}