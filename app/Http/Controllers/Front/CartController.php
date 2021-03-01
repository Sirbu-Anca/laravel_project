<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\HTMLmail;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $productsCart = [];
        if (count(session()->get('cart', []))) {
            $cart = session()->get('cart');
            $productsCart = Product::query()
                ->whereIn('id', $cart)
                ->get();
        }
        if (count($productsCart)) {
            return view('front.cart', compact('productsCart'));
        } else {
            return redirect()->route('products.index')->with('warning', 'Your cart is empty');
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request ): RedirectResponse
    {
        $id = $request->input('productId');
        $request->session()->put('cart.'.$id, $id);
        return redirect()
            ->route('products.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        $productsCart = [];
        if (count(session()->get('cart', []))) {
            $cart = session()->get('cart');
            $productsCart = Product::query()
                ->whereIn('id', $cart)
                ->get();
        }

        $inputs = $request->validate([
            'name' => 'required',
            'contactDetails' => 'required|email',
            'comments' => '',
        ]);

        $order = new Order();
        $order->name = $request->input('name');
        $order->contactDetails = $request->input('contactDetails');
        $order->comments = $request->input('comments');
        $order->save();

        foreach ($productsCart as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->price = $product->price;
            $orderProduct->save();
        }

        \Mail::to(config('mail.to'))
            ->send( new HTMLmail($productsCart, $inputs));
        $request->session()->forget('cart');

        return redirect()->route('products.index')
            ->with('success', 'Email sent!');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy( Request $request, Product $product ): RedirectResponse
    {
        $request->session()->forget('cart.'.$product->id);
        return redirect()
            ->route("cart.index");
    }
}
