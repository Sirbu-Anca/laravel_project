
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
</head>
<script type="text/javascript">
    $(document).ready(function () {
        const showCartRoute = '{{ route('cart.show') }}';
        const showProducts = '{{ route('products.get') }}';
        const submitRoute = '{{ route('email.send') }}';
        const addRoute = '{{ route('cart.store') }}';
        const loginRoute = '{{ route('login') }}'
        const loginFormRoute = '{{ route('login.form') }}'
        const listAllProducts = '{{ route('backend.products.index') }}'
        let   isAuthenticate = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        function renderList(products) {
            html = [
                '<tr>',
                '<th>Title</th>',
                '<th>Description</th>',
                '<th>Price</th>',
                '<th>Action</th>',
                '</tr>'
            ].join('');

            $.each(products, function (key, product) {
                html += [
                    '<tr>',
                    '<td>' + product.title + '</td>',
                    '<td>' + product.description + '</td>',
                    '<td>' + product.price + '</td>',
                    '<td>' +
                    '<button class="addToCart" value="' + product.id + '">Add</button>' +
                    '</td>',
                    '</tr>'
                ].join('');
            });

            return html;
        }

        $('.list').on('click', 'button.addToCart', function () {
            $.ajax(addRoute, {
                dataType: 'json',
                type: 'POST',
                data: {
                    productId: this.value,
                },
                success: function (response) {
                    alert(response.message)
                    window.onhashchange();
                }
            });
        })

        function renderCartList(products) {
            html = [
                '<tr>',
                '<th>Title</th>',
                '<th>Description</th>',
                '<th>Price</th>',
                '<th>Action</th>',
                '</tr>'
            ].join('');

            $.each(products, function (key, product) {
                html += [
                    '<tr>',
                    '<td>' + product.title + '</td>',
                    '<td>' + product.description + '</td>',
                    '<td>' + product.price + '</td>',
                    '<td><button class="removeFromCart" value="' + product.id + '">Remove</button></td>',
                    '</tr>'
                ].join('');
            });
            return html;
        }

        $('.list').on('click', 'button.removeFromCart', function () {
            let removeRoute = '{{ route('cart.destroy', 'remove_id') }}';
            removeRoute = removeRoute.replace('remove_id', this.value)
            let tr = $(this).parents('tr');
            $.ajax(removeRoute, {
                dataType: 'json',
                type: 'POST',
                data: {
                    productId: this.value,
                    _method: 'delete',
                },
                success: function (response) {
                    alert(response.message)
                    tr.remove();
                }
            });
        });

        $(function () {
            $('#checkout').on('submit', function (e) {
                e.preventDefault();
                $.ajax(submitRoute, {
                    type: 'POST',
                    data: {
                        name: this.name.value,
                        contact_details: this.contact_details.value,
                        comments: this.comments.value,
                    },
                    success: function () {
                        document.getElementById('checkout').reset();
                        window.location = '#';
                        alert('Order sent!')
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON.errors, function (key, error) {
                            alert(error)
                        });
                    },
                });
            });
        });

        $(function () {
            $('#login').on('submit', function (e) {
                e.preventDefault();
                console.log('I m still ok till here.');
                debugger
                $.ajax(loginRoute, {
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: this.email.value,
                        password: this.password.value,
                    },
                    success: function (response) {
                        console.log(response)
                        debugger;
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON.errors, function (key, error) {
                            alert(error)
                        });
                    },
                });
            });
        });

        /**
         * URL hash change handler
         */
        window.onhashchange = function () {
            // First hide all the pages
            $('.page').hide();

            switch (window.location.hash) {
                case '#cart':
                    // Show the cart page
                    $('.cart').show();
                    // Load the cart products from the server
                    $.ajax(showCartRoute, {
                        dataType: 'json',
                        success: function (response) {
                            if (response.length !== 0) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderCartList(response));
                            } else {
                                window.location = '#';
                                alert('Your cart is empty!');
                            }
                        }
                    });
                    break;
                    case '#login':
                        // Show the login page
                        $('.login').show();
                        $.ajax(loginFormRoute, {
                            dataType: 'html',
                            success: function (html) {
                                $('.login').html(html)
                            }
                        });
                    break;

                case '#products':
                    // Show the login page
                    $('.products').show();
                    $.ajax(listAllProducts, {
                        dataType: 'json',
                        success: function (response) {
                            debugger;
                            $('.products .list').html(renderList(response.data));
                        }
                    });
                    break;

                default:
                    // If all else fails, always default to index
                    // Show the index page
                    $('.index').show();
                    // Load the index products from the server
                    $.ajax(showProducts, {
                        dataType: 'json',
                        success: function (response) {
                            if (response.data.length !== 0) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response.data));
                            } else {
                                window.location = '#cart';
                                alert('All products are in your cart!');
                            }
                        }
                    });
                    break;
            }
        }
        window.onhashchange();
    });
</script>
<body>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="float:right">
    <!-- Authentication Links -->
    @guest
        <a class="dropdown-item" href="#login">{{ __('Login') }}</a>
        @if (Route::has('register'))
            <a class="dropdown-item" href="#register">{{ __('Register') }}</a>
        @endif
    @else
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="#logout" method="POST" class="d-none">
            </form>
        </div>
    @endguest
</div>
<!-- The login page -->
<div class="page login">
        <!-- Form login -->
</div>
<!-- The products page -->

<div class="page products">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>
    <!-- A link to go to the cart by changing the hash -->
    <a href="#product" class="button">{{ __('Add new product') }}</a>
</div>

<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">{{ __('Go to cart') }}</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>
    <div class="col-md-3">
        <form action="" method="post" id="checkout">
            <div class="mb-3">
                <input type="text" class="form-control" name="name"
                       placeholder="{{ __('Name') }}" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control "
                       name="contact_details" placeholder="{{ __('Contact details') }}"
                       value="{{ old('contact_details') }}">
            </div>
            <div class="mb-3">
                <textarea name="comments" class="form-control" rows="3" placeholder="{{ __('Comments') }}"></textarea>
            </div>
            <div>
                <button type="submit">{{ __('Checkout') }}</button>
            </div>
        </form>
    </div>
    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">{{ __('Go to index') }}</a>
</div>
</body>
</html>

