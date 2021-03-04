@extends('backend.layout')

@section('header')
    {{ __('Order details') }}
@endsection

@section('content')
    @php
        /* @var \App\Models\Order $order */
    @endphp
    <div class="row">
        <div class="col-8">
            <table>
                <tr>
                    <td>
                        <p>
                            {{ __('Date:') }}
                            {{ $order->created_at}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            {{ __('Name:') }}
                            {{ $order->name  }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            {{ __('Address') }}
                            {{ $order->contact_details }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            @if ($order->comments)
                                {{ __('Comments:') }}
                                {{ $order->comments }}
                            @endif
                        </p>
                    </td>
                </tr>
                @foreach ($order->products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->getPhotoUrl() }}" alt="{{ __('Product photo') }}"
                                 style="width: 100px;height: 100px">
                        </td>
                        <td>
                            <div>{{ $product->title }}</div>
                            <div>{{ $product->description }}</div>
                            <div>{{ $product->pivot->price }}</div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
