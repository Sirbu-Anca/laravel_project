<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        if (request()->ajax()) {
            return response()->json($order);
        } else {
            return view('backend.orders.show', compact('order'));
        }

    }

}
