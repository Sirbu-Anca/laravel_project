<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
</head>
<script type="text/javascript">
    $(document).ready(function () {

        /**
         * A function that takes a products array and renders it's html
         *
         * The products array must be in the form of
         * [{
         *     "title": "Product 1 title",
         *     "description": "Product 1 desc",
         *     "price": 1
         * },{
         *     "title": "Product 2 title",
         *     "description": "Product 2 desc",
         *     "price": 2
         * }]
         */

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
                    '<td>'+
                    '<button class="addToCart" value="'+product.id+'">Add</button>'+
                    '</td>',
                    '</tr>'
                ].join('');
            });

            return html;
        }

        const addRoute = '{{ route('cart.store') }}';
        $('.list').on('click', 'button.addToCart', function() {
            $.ajax(addRoute, {
                dataType: 'json',
                type:'POST',
                data:{
                    _token: '{{ csrf_token() }}',
                    productId:this.value,
                },
                success: function () {
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

        $('.list').on('click', 'button.removeFromCart', function() {
            let removeRoute = '{{ route('cart.destroy', 'remove_id') }}';
            removeRoute = removeRoute.replace('remove_id', this.value)
            let tr = $(this).parents('tr');
            $.ajax(removeRoute, {
                dataType: 'json',
                type:'POST',
                data:{
                    _token: '{{ csrf_token() }}',
                    productId:this.value,
                    _method: 'delete',
                },
                success: function () {
                    tr.remove();
                }
            });
        })

        /**
         * URL hash change handler
         */
        window.onhashchange = function () {
            // First hide all the pages
            $('.page').hide();

            switch(window.location.hash) {
                case '#cart':
                    // Show the cart page
                    $('.cart').show();
                    // Load the cart products from the server
                    $.ajax('{{ route('cart.show') }}', {
                        dataType: 'json',
                        success: function (response) {
                            // Render the products in the cart list
                            $('.cart .list').html(renderCartList(response));
                        }
                    });
                    break;
                default:
                    // If all else fails, always default to index
                    // Show the index page
                    $('.index').show();
                    // Load the index products from the server
                    $.ajax('{{ route('products.get') }}', {
                        dataType: 'json',
                        success: function (response) {
                            // Render the products in the index list
                            $('.index .list').html(renderList(response.data));
                        }
                    });
                    break;
            }
        }

        window.onhashchange();
    });
</script>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">Go to cart</a>
</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>
</div>
</body>
</html>
