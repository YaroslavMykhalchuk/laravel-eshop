<div>

    @section('metatags')
        <title>{{ config('app.name') . ' :: ' . ($title ?? 'Page Title') }}</title>
        <meta name="description" content="{{ $desc ?? 'default' }}">
    @endsection

    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
                        <li><span>Cart</span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-8 mb-3">
                <div class="cart-content p-3 h-100 bg-white">

                    @if($cart = \App\Helpers\Cart\Cart::getCart())
                        <div class="table-responsive position-relative">

                            <div class="update-loading" wire:loading wire:target="updateItemQuantity, removeFromCart, clearCart">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>

                            <table class="table align-middle table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>Photo</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th><i class="fa-regular fa-trash-can"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td class="product-img-td">
                                                <a href="{{ route('product', $item['slug']) }}" wire:navigate>
                                                    <img src="{{ asset($item['image']) }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('product', $item['slug']) }}" class="cart-content-title">
                                                    {{ $item['title'] }}
                                                </a>
                                            </td>
                                            <td class="text-center">${{ $item['price'] }}</td>
                                            <td x-data="{ qty: {{ $item['quantity'] }} }">
                                                <div class="input-group cart-block">
                                                    <input
                                                        type="number"
                                                        value="{{ $item['quantity'] }}"
                                                        x-model="qty"
                                                        class="form-control cart-qty"
                                                        min="1">
                                                    <button
                                                        class="btn btn-warning"
                                                        wire:loading.attr="disabled"
                                                        x-on:click="$wire.updateItemQuantity({{ $id }}, qty)">
                                                        <i class="fa-solid fa-arrows-rotate"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center">${{ $item['quantity'] * $item['price'] }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-danger"
                                                    wire:click="removeFromCart({{ $id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="removeFromCart">
                                                    <i class="fa-regular fa-circle-xmark"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <button
                                            class="btn btn-outline-danger"
                                            wire:click="clearCart"
                                            wire:loading.attr="disabled"
                                            wire:target="clearCart">Clear Cart</button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p>Cart is empty...</p>
                    @endif


                </div>
            </div>

            <div class="col-lg-4 mb-3">

                <div class="cart-summary p-3 sidebar">
                    <h5 class="section-title"><span>Cart Summary</span></h5>

                    <div class="d-flex justify-content-between my-3">
                        <h6>Products</h6>
                        <h6>{{ \App\Helpers\Cart\Cart::getCartQuantityItems() }}</h6>
                    </div>

                    <div class="d-flex justify-content-between my-3 border-bottom">
                        <h6>Items</h6>
                        <h6>{{ \App\Helpers\Cart\Cart::getCartQuantityTotal() }}</h6>
                    </div>

                    <div class="d-flex justify-content-between my-3">
                        <h3>Total</h3>
                        <h3>{{ \Illuminate\Support\Number::currency(\App\Helpers\Cart\Cart::getCartTotalSum(), in: 'USD', precision: 0) }}</h3>
                    </div>

                    @if($cart)
                        <div class="d-grid">
                            <a href="{{ route('checkout') }}" class="btn btn-warning" wire:navigate>Checkout</a>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

</div>
