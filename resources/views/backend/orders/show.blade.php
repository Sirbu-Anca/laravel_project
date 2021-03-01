@extends('backend.layout')

@section('content')
    @php
        /* @var \App\Models\Order $order */
    @endphp
    <h4>{{ __('Order details') }}</h4>
    <div class="row">
        <div class="col-8">
            <table class="">
                <tr>
                    <td>
                        <p>
                            {{__('Date:')}}
                            {{ $order->created_at}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            {{__('Name:')}}
                            {{ $order->name  }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            {{__('Address')}}
                            {{ $order->contactDetails }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            @if($order->comments)
                                {{ __('Comments:') }}
                                {{ $order->comments }}
                            @endif
                        </p>
                    </td>
                </tr>
                <?php foreach ($order->products as $product) : ?>
                <tr>
                    <td>
                        <img src="{{ $product->getPhotoUrl() }}" alt="Product photo"
                             style="width: 100px;height: 100px">
                    </td>
                    <td>
                        <div>{{ $product->title }}</div>
                        <div>{{ $product->description }}</div>
                        <div>{{ $product->pivot->price }}</div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
@endsection
