@extends('backend.layout')
@section('header')
    {{__('Insert product details')}}
@endsection
@section('content')
    <div class="col-md-3">
        <form action="{{ route('backend.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                       placeholder="{{__('Title')}}" value="{{ old('title')}}">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                       placeholder="{{__('Description')}}" value="{{ old('description') }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                       placeholder="{{__('Price')}}" value="{{ old('price') }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="file" class="form-control @error('image_name') is-invalid @enderror" name="image_name"
                       placeholder="{{__('Image_name')}}">
                @error('image_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ __($message) }}</strong>
                </span>
                @enderror
            </div>
            <div>
                <button type="submit">{{__('Save')}}</button>
            </div>
        </form>
    </div>
@endsection
