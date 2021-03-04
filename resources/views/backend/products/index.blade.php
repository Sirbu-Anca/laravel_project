@extends('backend.layout')

@section('header')
    {{ __('List of products') }}
    <a href="{{ route('backend.products.create') }}" class="btn btn-primary float-right">{{ __('Add new') }}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <table class="table table-striped">
                @foreach ($products as $product)
                    <tr>
                        <th>
                            @if ($product->image)
                                <img src="{{ $product->getPhotoUrl() }}" alt="{{ __('Product photo') }}"
                                     style="width: 100px;height: 100px">
                            @endif
                        </th>
                        <td>
                            <div>{{ $product->title }}</div>
                            <div>{{ $product->description }}</div>
                            <div>{{ $product->price }}</div>
                        </td>
                        <td><a href="{{ route('backend.products.edit', $product) }}">{{ __('Edit') }}</a></td>
                        <td>
                            <form action="{{ route('backend.products.destroy', $product) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{ $products->links('pagination::bootstrap-4') }}
@endsection
