<div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumbs">
                    <ul>
                        <li><a wire:navigate href="{{ route('home') }}">Home</a></li>
                        <li><a wire:navigate href="{{ route('account') }}">Account</a></li>
                        <li><a wire:navigate href="{{ route('orders') }}">Orders</a></li>
                        <li><span>Orders</span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-4 mb-3">
                <div class="cart-summary p-3 sidebar">
                    <h5 class="section-title"><span>Links</span></h5>
                    @include('incs.account-links')
                </div>
            </div>

            <div class="col-lg-8 mb-3">
                <div class="cart-content p-3 h-100 bg-white">
                    <h5 class="section-title"><span>Details order #{{ $order->id }}</span></h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hove">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>View product</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderProducts as $product)
                                <tr wire:key="{{ $product->id }}">
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="">
                                    </td>
                                    <td>
                                        <a href="{{ route('product', $product->slug) }}" wire:navigate>
                                            {{ $product->title }}
                                        </a>
                                    </td>
                                    <td>{{ \Illuminate\Support\Number::currency($product->price, in: 'USD', precision: 0) }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ \Illuminate\Support\Number::currency($product->price * $product->quantity, in: 'USD', precision: 0) }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-warning" href="{{ route('product', $product->slug) }}" wire:navigate>
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <strong>
                                            Total: {{ \Illuminate\Support\Number::currency($order->total, in: 'USD', precision: 0) }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($order->note)
                        <p>
                            <strong>Note: </strong>
                            {{ $order->note }}
                        </p>
                    @endif

                </div>
            </div>

        </div>
    </div>

</div>
