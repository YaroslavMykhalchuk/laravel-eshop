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
                        <li><a wire:navigate href="{{ route('home') }}">Home</a></li>
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
                    <h5 class="section-title"><span>Orders</span></h5>

                    @if($orders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hove">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th><i class="fa-solid fa-eye"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr wire:key="{{ $order->id }}">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ \Illuminate\Support\Number::currency($order->total, in: 'USD', precision: 0) }}</td>
                                            <td>{{ $order->status ? 'Completed' : 'New' }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->updated_at }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-warning" href="{{ route('order-show', $order->id) }}" wire:navigate>
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $orders->links() }}
                    @else
                        <p>No orders...</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
