<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $orders = Order::query()
            ->select('orders.id', 'order_product.price', DB::raw('SUM(price) as total_sum'))
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('order_id')
            ->paginate(10);

        if (request()->ajax()) {
            return response()->json($orders);
        } else {
            return view('backend.orders.index', compact('orders'));
        }
    }

    /**
     * Display the specified resource.
     * @param Order $order
     */
    public function show(Order $order)
    {
        $products = OrderProduct::query()
            ->select('products.title', 'products.description', 'order_product.price')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('order_id', '=', $order->id)
            ->paginate(10);

        if (request()->ajax()) {
            return response()->json([$order, $products]);
        } else {
            return view('backend.orders.show', compact('order'));
        }
    }
}
