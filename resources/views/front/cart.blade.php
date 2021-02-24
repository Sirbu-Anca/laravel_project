@extends('layouts.app')

@section('content')
<h3>{{ __('Cart products') }}</h3>
<div class="col-md-3">
    <table border="1px bold black">
        @foreach($productsCart as $product)
            <tr>
                <td>
                    <img src="{{ $product->image_name }}" alt="image">
                </td>
                <td>
                    <div>{{ $product->title }}</div>
                    <div>{{ $product->description }}</div>
                    <div>{{ $product->price }}</div>
                </td>
                <td>
                    <form action="{{ route('cart.destroy', $product) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">{{__('Remove')}}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<div class="col-md-3">
    <form action="{{ route('email.send') }}" method="post">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name') }}">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <input type="text" class="form-control @error('contactDetails') is-invalid @enderror" name="contactDetails"  placeholder="{{__('Contact details')}}" value="{{ old('contactDetails') }}">
            @error('contactDetails')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <textarea name="comments" class="form-control" rows="3" placeholder="{{__('Comments')}}" ></textarea>
        </div>
        <div>
            <button type="submit" name="submit">{{__('Checkout')}}</button>
        </div>
    </form>
</div>
<div class="col-md-4">
    <a href="{{ route('products.index') }}">{{__('Go to index')}}</a>
</div>
@endsection
