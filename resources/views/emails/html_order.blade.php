<div class="col-md-4">
    <tr>
        <td>
            <p>
                {{ __('Name:')  }}
                {{ $inputs['name'] }}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p>
                {{ __('Contact:') }}
                {{ $inputs['contactDetails'] }}
            </p>
        </td>
    </tr>
    @if(!empty($inputs['comments']))
    <tr>
        <td>
            <p>
                {{__('Comments:')}}
                {{ $inputs['comments'] }}
            </p>
        </td>
    </tr>
    @endif
    <table border="1px bold black">
        @foreach($cartProducts as $product)
            <tr>
                <td>
                    <img src="{{ $product->getPhotoUrl() }}" alt="Product photo"
                         style="width: 100px;height: 100px">
                </td>
                <td>
                    <div>{{ $product->title }}</div>
                    <div>{{ $product->description }}</div>
                    <div>{{ $product->price }}</div>
                </td>
            </tr>
        @endforeach
    </table>
</div>

