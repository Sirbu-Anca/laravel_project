@extends('backend.layout')

@section('header')
    {{ __('Update product') }}
@endsection

@section('content')
    <div class="col-md-3">
        <form action="{{ route('backend.products.update' ,$product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                       placeholder="{{ __('Title') }}" value="{{ $product->title }}">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                       placeholder="{{ __('Description') }}" value="{{ $product->description }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                       placeholder="{{ __('Price') }}" value="{{ $product->price }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="file" class="form-control @error('image_name') is-invalid @enderror" name="image_name"
                       placeholder="{{ __('Image_name') }}" value="{{ null }}">
                @error('image_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div>
                <button type="submit">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
@endsection
