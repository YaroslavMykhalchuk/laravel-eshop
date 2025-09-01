<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Orders List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">Status</th>
                            <th class="col-2">Total</th>
                            <th class="col-2">Created</th>
                            <th class="col-2">Updated</th>
                            <th class="col-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr wire:key="{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->status ? 'Completed' : 'New' }}</td>
                                <td>${{ $order->total }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->updated_at }}</td>
                                <td>
                                    <a class="btn btn-info btn-circle" href="{{ route('admin.orders.edit', $order->id) }}" wire:navigate>
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button class="btn btn-danger btn-circle" wire:click="deleteOrder({{ $order->id }})" wire:confirm="Are you sure?" wire:loading.attr="disabled">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
