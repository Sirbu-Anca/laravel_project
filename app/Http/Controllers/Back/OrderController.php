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
    public function index(): Factory|View|Application
    {
        $orders = OrderProduct::query()
            ->select('order_id', 'price', DB::raw('SUM(price) as total_sum'))
            ->groupBy('order_id')
            ->paginate(5);
        return view('backend.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order): Factory|View|Application
    {
        return view('backend.orders.show', compact('order'));
    }

}
