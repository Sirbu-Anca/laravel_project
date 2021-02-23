<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $cart = session()->get('cart');

        $products = Product::query()
            ->whereIn('id', $cart)
            ->paginate(5);
        return view('front.cart', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request )
    {
        $id = $request['productId'];
        $request->session()->put('cart.'.$id, $id);
        return redirect()
            ->route('products.index');
    }

    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'contactDetails' => 'required|email:rfc,dns',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product

     */
    public function destroy( Request $request, Product $product )
    {
        $request->session()->forget('cart.'.$product->id);
        return redirect()
            ->route("cart.index");
    }
}
