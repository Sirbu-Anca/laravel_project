@extends('backend.layout')
@section('content')
    <div class="row">
        <div class="col-8">
            <table class="table table-striped">
                <tr>
                    <th>{{__('Order id')}}</th>
                    <th>{{__('Total Sum')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                @foreach ($orders as $order)
                <tr>
                    <td>
                        {{ $order->order_id }}
                    </td>
                    <td>
                        {{ $order->total_sum }} eur
                    </td>
                    <td><a href="{{ route('backend.orders.show', $order->order_id) }}">{{__('Show')}}</a></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
