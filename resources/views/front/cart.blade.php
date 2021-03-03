@extends('layouts.app')

@section('content')
    <h3>{{ __('Cart products') }}</h3>
    <div class="col-md-3">
        <table border="1px bold black">
            @foreach ($productsCart as $product)
                <tr>
                    <td>
                        <img src="{{ $product->getPhotoUrl() }}" alt="{{__('Product photo')}}"
                             style="width: 100px;height: 100px">
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
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                       placeholder="{{__('Name')}}" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control @error('contact_details') is-invalid @enderror"
                       name="contact_details" placeholder="{{__('Contact details')}}"
                       value="{{ old('contact_details') }}">
                @error('contact_details')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
            </span>
                @enderror
            </div>
            <div class="mb-3">
                <textarea name="comments" class="form-control" rows="3" placeholder="{{__('Comments')}}"></textarea>
            </div>
            <div>
                <button type="submit">{{__('Checkout')}}</button>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <a href="{{ route('products.index') }}">{{__('Go to index')}}</a>
    </div>
@endsection
