
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
</head>
<script type="text/javascript">
    $(document).ready(function () {
        let indexProductsRoute = '{{ route('products.get') }}';
        let addToCartRoute = '{{ route('cart.store') }}';

        let cartProductsRoute = '{{ route('cart.show') }}';
        let sendOrderRoute = '{{ route('email.send') }}';
        let removeFromCartRoute = '{{ route('cart.destroy', 'remove_id') }}';

        let loginRoute = '{{ route('login') }}';
        let registerRoute = '{{ route('register') }}'
        let logoutRoute = '{{ route('logout') }}';

        let allProductsRoute = '{{ route('backend.products.index') }}';
        let deleteProductRoute = '{{ route('backend.products.destroy', 'delete_id') }}';
        let addProductRoute = '{{ route('backend.products.store') }}'
        let editProductRoute = '{{ route('backend.products.edit', 'edit_id') }}';
        let editHash = undefined;
        let updateProductRoute = '{{ route('backend.products.update', 'update_id') }}';
        let ordersListRoute = '{{ route('backend.orders.index') }}';
        let orderRoute = '{{ route('backend.orders.show', 'order_id') }}'
        let list = $('.list');
        let isAuthenticated = {{ auth()->check() ? 1 : 0 }};

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
        function renderAllProducts(products) {
            html = [
                '<tr>',
                '<th>Title</th>',
                '<th>Description</th>',
                '<th>Price</th>',
                '<th colspan="2">Action</th>',
                '</tr>'
            ].join('');

            $.each(products, function (key, product) {
                html += [
                    '<tr>',
                    '<td>' + product.title + '</td>',
                    '<td>' + product.description + '</td>',
                    '<td>' + product.price + '</td>',
                    '<td>' +
                    '<button class="editProduct" value="' + product.id + '">Edit</button>' +
                    '<td><button class="deleteProduct" value="' + product.id + '">Delete</button></td>',
                    '</td>',
                    '</tr>'
                ].join('');
            });
            return html;
        }

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

        function renderAllOrders(orders) {
            html = [
                '<tr>',
                '<th>Order id</th>',
                '<th>Total sum</th>', ,
                '<th>Action</th>',
                '</tr>'
            ].join('');

            $.each(orders, function (key, order) {
                html += [
                    '<tr>',
                    '<td>' + order.id + '</td>',
                    '<td>' + order.total_sum + '</td>',
                    '<td><button class="showOrder" value="' + order.id + '">Show</button></td>',
                    '</td>',
                    '</tr>'
                ].join('');
            });
            return html;
        }
        function renderOrder(order) {
            html = [
                '<tr>',
                '<th>Name</th>',
                '<th>Address</th>', ,
                '<th>Comments</th>',
                '</tr>'
            ].join('');
            html += [
                '<tr>',
                '<td>' + order.name + '</td>',
                '<td>' + order.address + '</td>',
                '<td>' + order.comments + '</td>',
                '</td>',
                '</tr>'
            ].join('');
            return html;
        }


        // Add to cart
        list.on('click', 'button.addToCart', function () {
            $.ajax(addToCartRoute, {
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

        // remove product from cart
        list.on('click', 'button.removeFromCart', function () {
            let removeFromCartRouteId = removeFromCartRoute.replace('remove_id', this.value)
            let tr = $(this).parents('tr');
            $.ajax(removeFromCartRouteId, {
                dataType: 'json',
                type: 'POST',
                data: {
                    productId: this.value,
                    _method: 'delete',
                },
                success: function (response) {
                    alert(response.message)
                    tr.remove();
                    window.onhashchange();
                }
            });
        });

        // Send order
        $('#checkout').on('submit', function (e) {
            e.preventDefault();
            $.ajax(sendOrderRoute, {
                type: 'POST',
                data: $(this).serializeArray(),
                success: function () {
                    document.getElementById('checkout').reset();
                    window.location = '#';
                    window.onhashchange();
                    alert('Order sent!')
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                },
            });
        });

        // Login
        $('#login').on('submit', function (e) {
            e.preventDefault();
            $.ajax(loginRoute, {
                type: 'POST',
                data: $(this).serializeArray(),
                success: function (data, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        isAuthenticated = true;
                        window.location = '#products';
                        window.onhashchange();
                    }
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                }

            });
        });

        // register
        $('#register').on('submit', function (e) {
            e.preventDefault();
            $.ajax(registerRoute, {
                type: 'POST',
                data: $(this).serializeArray(),
                success: function () {
                    window.location = '#products';
                    window.onhashchange();
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                },
            });
        });

        // logout
        $('#logout-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax(logoutRoute, {
                type: 'POST',
                success: function () {
                    isAuthenticated = false;
                    window.location = '#';
                    window.onhashchange();
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                },
            });
        });

        //Delete product
        list.on('click', 'button.deleteProduct', function () {
            let deleteProductRouteId = deleteProductRoute.replace('delete_id', this.value)
            let tr = $(this).parents('tr');
            $.ajax(deleteProductRouteId, {
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

        // add new product
        $('#addProduct').on('submit', function (e) {
            e.preventDefault();
            let file = $('input[type=file]')[0].files[0]
            let myForm = document.getElementById('addProduct');
            let formData = new FormData(myForm);
            formData.append('file', file);
            $.ajax(addProductRoute, {
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    document.getElementById('addProduct').reset();
                    window.location = '#products';
                    window.onhashchange();
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                },
            });
        });

        list.on('click', 'button.editProduct', function () {
            editHash = '#edit-product/' + this.value;
            window.location = editHash;
            window.onhashchange();
        });

        $('#updateProduct').on('submit', function (e) {
            e.preventDefault();
            let update_id = window.location.hash.substr(window.location.hash.indexOf('/') + 1)
            let updateProductRouteId = updateProductRoute.replace('update_id', update_id)
            let myForm = document.getElementById('updateProduct');
            let formData = new FormData(myForm);
            $.ajax(updateProductRouteId, {
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function () {
                    document.getElementById('updateProduct').reset();
                    window.location = '#products';
                    window.onhashchange();
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (key, error) {
                        alert(error)
                    });
                },
            });
        });


        /**
         * URL hash change handler
         */
        window.onhashchange = function () {
            // First hide all the pages
            $('.page').hide();

            if (isAuthenticated) {
                $('#not-auth').hide()
                $('#auth').show()
            } else {
                $('#not-auth').show()
                $('#auth').hide()
            }

            let hash = window.location.hash;
            if (hash.search('#edit-product') !== -1) {
                hash = ('#edit-product');
            }

            switch (hash) {
                case '#cart':
                    // Show the cart page
                    // Load the cart products from the server
                    $.ajax(cartProductsRoute, {
                        dataType: 'json',
                        success: function (response) {
                            if (response.length !== 0) {
                                $('.cart').show();
                                // Render the products in the cart list
                                $('.cart .list').html(renderCartList(response));
                            } else {
                                window.location = '#';
                                window.onhashchange();
                                alert('Your cart is empty!');
                            }
                        }
                    });
                    break;

                case '#login':
                    // Show the login page
                    $('.login').show();
                    break;

                case '#register':
                    // Show the login page
                    $('.register').show();
                    break;

                case '#products':
                    // Show the products page
                    $.ajax(allProductsRoute, {
                        dataType: 'json',
                        success: function (response) {
                            if (response.data.length !== 0) {
                                $('.products').show();
                                $('.products .list').html(renderAllProducts(response.data));
                            } else {
                                alert('No products found!')
                            }
                        }
                    });
                    break;

                case '#create-product':
                    // Show create product page
                    $('.create-product').show();
                    break;

                case '#edit-product':
                    let id = window.location.hash.substr(window.location.hash.indexOf('/') + 1)
                    $('.edit-product').show();
                    let editProductRouteId = editProductRoute.replace('edit_id', id)
                    $.ajax(editProductRouteId, {
                        dataType: 'json',
                        data: {
                            productId: id,
                        },
                        success: function (response) {
                            $('#title').val(response.title);
                            $('#description').val(response.description);
                            $('#price').val(response.price);
                        }
                    });
                    break;

                case '#orders':
                    // Show orders page
                    $.ajax(ordersListRoute, {
                        dataType: 'json',
                        success: function (response) {
                            $('.orders').show();
                            $('.orders .list').html(renderAllOrders(response.data));
                        }
                    });
                    break;
                case '#order':
                    // Show order page
                    let  orderRouteId = orderRoute.replace('order_id', this.value)
                    debugger
                    $.ajax(orderRouteId, {
                        dataType: 'json',
                        success: function (response) {
                            debugger
                            $('.order').show();
                            $('.orders .list').html(renderOrder(response.data));
                        }
                    });
                    break;

                default:
                    // If all else fails, always default to index
                    // Show the index page
                    $('.index').show();
                    // Load the index products from the server
                    $.ajax(indexProductsRoute, {
                        dataType: 'json',
                        success: function (response) {
                            if (response.data.length !== 0) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response.data));
                            } else {
                                window.location = '#cart';
                                window.onhashchange();
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
<div>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="float:right">
        <!-- Authentication Links -->
        <div id="not-auth">
            <a class="dropdown-item" href="#login">{{ __('Login') }}</a>
            <a class="dropdown-item" href="#register">{{ __('Register') }}</a>
        </div>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="auth">
            <form id="logout-form" action="" method="POST" class="d-none">
                <button type="submit">{{ __('Logout') }}</button>
            </form>
        </div>

    </div>
    <!-- The login page -->
    <div class="page login">
        <form method="POST" action="" id="login">
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email-login" type="email" class="form-control " name="email"
                           value="{{ old('email') }}" autocomplete="email" >
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password-login" type="password" class="form-control"
                           name="password" autocomplete="current-password">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- The register page -->

    <div class="page register">
        <form method="POST" action="" id="register">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
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
    <!-- The form element where the customer fill contact details for order-->
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
            <a href="#" class="button">{{ __('Go to index') }}</a>
        </div>
    </div>
    <!-- A link to go to the index by changing the hash -->

    <!-- The products page -->
    <div class="page products">
        <a href="#orders" class="button">{{ __('Show orders') }}</a>
        <!-- The products element where the products list is rendered -->
        <table class="list">

        </table>
        <!-- A link to go to the product by changing the hash -->
        <a href="#create-product" class="button">{{ __('Add new product') }}</a>
    </div>

    <!-- The product page -->
    <div class="page create-product">
        <form action="" method="POST" enctype="multipart/form-data" id="addProduct">
            <div class="mb-3">
                <input type="text" class="form-control" name="title"
                       placeholder="{{ __('Title') }}" value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="description"
                       placeholder="{{ __('Description') }}" value="{{ old('description') }}">
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="price"
                       placeholder="{{ __('Price') }}" value="{{ old('price') }}">
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" name="image"
                       placeholder="{{ __('image') }}">
            </div>
            <div>
                <button type="submit">{{ __('Save') }}</button>
            </div>
        </form>
        <!-- A link to go to the product by changing the hash -->
        <a href="#products" class="button">{{ __('Products list') }}</a>
    </div>

    <!-- Edit product page -->
    <div class="page edit-product">
            <form action="" method="POST" enctype="multipart/form-data" id="updateProduct">
                @method('PUT')
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" id="title"
                           placeholder="{{ __('Title') }}" value="">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="description" id="description"
                           placeholder="{{ __('Description') }}" value="">
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="price" id="price"
                           placeholder="{{ __('Price') }}" value="">
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" name="image" id="image"
                           placeholder="">
                </div>
                <div>
                    <button type="submit">{{ __('Update') }}</button>
                </div>
            </form>
        <a href="#products" class="button">{{ __('Products list') }}</a>
    </div>

    <!-- The orders page -->
    <div class="page orders">
        <!-- The page where the orders list is rendered -->
        <table class="list"></table>
        <a href="#products" class="button">{{ __('Products list') }}</a>
    </div>
    <!-- The order page -->
    <div class="page order">
        <!-- The page where the order  is rendered -->
        <table class="list"></table>
        <a href="#orders" class="button">{{ __('Orders list') }}</a>
    </div>
</div>
</body>
</html>

