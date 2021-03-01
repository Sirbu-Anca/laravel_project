@extends('backend.layout')

@section('content')
    <div class="row">
        <div class="col-8">
            <table class="table table-striped">
                @foreach($products as $product)
                    <tr>
                        <th>
                            @if($product->image_name)
                                <img src="{{ $product->getPhotoUrl() }}" alt="Product photo"
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
                                <button type="submit">{{__('Delete')}}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
