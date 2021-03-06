@extends('layouts.app')

@section('content')
    <h3>{{ __('Products') }}</h3>
    <table border="1px bold black">
        @foreach ($products as $product)
            <tr>
                <th>
                    <img src="{{ $product->getPhotoUrl() }}" alt="{{ __('Product photo') }}"
                         style="width: 100px;height: 100px">
                </th>
                <td>
                    <div>{{ $product->title }}</div>
                    <div>{{ $product->description }}</div>
                    <div>{{ $product->price }}</div>
                </td>
                <td>
                    <form action="{{ route('cart.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <button type="submit">{{ __('Add') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $products->links('pagination::bootstrap-4') }}
    <a href="{{ route('cart.index') }}">{{ __('Go to cart') }}</a>
@endsection
