@extends('layouts.app')

@section('content')
    <h3>{{__('Products')}}</h3>
    <table border="1px bold black">
        @foreach($products as $product)

            <tr>
                <th>
                   <img src="{{ $product->image_name }}" alt="Product photo">
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
                        <button type="submit">{{__('Add')}}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <a href="{{ route('cart.index') }}">{{__('Go to cart')}}</a>
@endsection
