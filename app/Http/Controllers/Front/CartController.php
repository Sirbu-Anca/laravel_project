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
    public function index()
    {
        return view('main');
    }

    public function displayCartProducts()
    {
        $cartProducts = $this->getCartProducts();
        if (\request()->ajax()) {
            return response()->json($cartProducts);
        } else {
            return view('front.cart', compact('cartProducts'));
        }
    }

    /**
     * @return Collection|array
     */
    protected function getCartProducts()
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
     */
    public function store(Request $request)
    {
        $id = $request->input('productId');
        $product = Product::query()->findOrFail($id);
        $request->session()->put('cart.' . $id, $id);
        if ($request->ajax()) {
            return response()->json(['message' => $product->title . __(' successfully added to cart.' )]);
        } else {
            return redirect()
                ->route('products.index')
                ->with('success', $product->title . __(' successfully added in cart'));
        }


    }

    public function sendEmail(Request $request)
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

        if ($request->ajax()) {
            return response()->json(['message' => __('Order sent!')]);
        } else {
            return redirect()->route('products.index')
                ->with('success', __('Order sent!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Product $product
     */
    public function destroy(Request $request, Product $product)
    {
        $request->session()->forget('cart.' . $product->id);
        if ($request->ajax()) {
            return response()->json(['message' => $product->title . __(' removed from cart successfully!')]);
        } else {
            return redirect()
                ->route("cart.show");
        }
    }
}
