<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Orders #{{ $order->id }} ({{ $status ? 'Completed' : 'New' }})
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="width: 30%;">
                            <col style="width: 70%;">
                        </colgroup>
                        <tbody>

                            <tr>
                                <th>#</th>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Customer name</th>
                                <td>{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <th>Customer email</th>
                                <td>{{ $order->email }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" wire:model.live="status" >
                                        <label class="custom-control-label" for="status">{{ $status ? 'Completed' : 'New' }}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>${{ $order->total }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated</th>
                                <td>{{ $order->updated_at }}</td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>{{ $order->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Orders Products
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderProducts as $product)
                            <tr wire:key="{{ $product->id }}">
                                <td><img src="{{ asset($product->image) }}" alt="Image ordered product" height="50px"></td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right font-weight-bold">Total: ${{ $order->total }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
