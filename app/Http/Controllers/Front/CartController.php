<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
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
        $cartProducts = $this->getCartProducts();
        if (count($cartProducts)) {
            return view('front.cart', compact('cartProducts'));
        } else {
            return redirect()->route('products.index')
                ->with('warning', __('Your cart is empty'));
        }
    }

    /**
     * @return Collection|array
     */
    protected function getCartProducts(): Collection|array
    {
        $cartProducts = [];
        if (count(session()->get('cart', []))) {
            $cart = session()->get('cart');
            $cartProducts = Product::query()
                ->whereIn('id', $cart)
                ->get();
        }
        return $cartProducts;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $id = $request->input('productId');
        $product = Product::query()->findOrFail($id);
        $request->session()->put('cart.' . $id, $id);
        return redirect()
            ->route('products.index')
            ->with('success', $product->title . __(' successfully added in cart'));
    }

    /**shop
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        $cartProducts = $this->getCartProducts();

        if ($cartProducts) {
            $inputs = $request->validate([
                'name' => 'required',
                'contact_details' => 'required|email',
                'comments' => 'nullable'
            ]);

            $order = Order::create($inputs);
            foreach ($cartProducts as $product) {
                $order->products()->attach($product->id, ['price' => $product->price]);
            }

            Mail::to(config('mail.to'))
                ->send(new OrderConfirmation($cartProducts, $inputs));
            $request->session()->forget('cart');
        }
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
