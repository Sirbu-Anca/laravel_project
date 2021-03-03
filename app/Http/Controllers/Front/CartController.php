<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\HTMLmail;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mail;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): Factory|View|RedirectResponse|Application
    {
        $productsCart = $this->getProductsCart();
        if (count($productsCart)) {
            return view('front.cart', compact('productsCart'));
        } else {
            return redirect()->route('products.index')
                ->with('warning', __('Your cart is empty'));
        }
    }

    /**
     * @return Collection|array
     */
    protected function getProductsCart(): Collection|array
    {
        $productsCart = [];
        if (count(session()->get('cart', []))) {
            $cart = session()->get('cart');
            $productsCart = Product::query()
                ->whereIn('id', $cart)
                ->get();
        }
        return $productsCart;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $id = $request->input('productId');
        $request->session()->put('cart.' . $id, $id);
        return redirect()
            ->route('products.index');
    }

    /**shop
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        $productsCart = $this->getProductsCart();

        $inputs = $request->validate([
            'name' => 'required',
            'contact_details' => 'required|email',
            'comments' => 'nullable'
        ]);

        $order = new Order();
        $order->name = $request->input('name');
        $order->contact_details = $request->input('contact_details');
        $order->comments = $request->input('comments');
        $order->save();

        foreach ($productsCart as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->price = $product->price;
            $orderProduct->save();
        }

        Mail::to(config('mail.to'))
            ->send(new HTMLmail($productsCart, $inputs));
        $request->session()->forget('cart');

        return redirect()->route('products.index')
            ->with('success', __('Email sent!'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $request->session()->forget('cart.' . $product->id);
        return redirect()
            ->route("cart.index");
    }
}
