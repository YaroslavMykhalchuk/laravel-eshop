<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target.except="deleteProduct">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary" wire:navigate>Add Product</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th class="col-1">Image</th>
                            <th class="col-4">Title</th>
                            <th class="col-3">Category</th>
                            <th class="col-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr wire:key="{{ $product->id }}">
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ asset($product->getImage()) }}" alt="Product image" height="50px"></td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category->title }}</td>
                                    <td>
                                        <a class="btn btn-info btn-circle" href="{{ route('product', $product->slug) }}" wire:navigate target="_blank">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-circle" href="{{ route('admin.products.edit', $product->id) }}" wire:navigate>
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <button class="btn btn-danger btn-circle" wire:click="deleteProducts({{ $product->id }})" wire:confirm="Are you sure?" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
