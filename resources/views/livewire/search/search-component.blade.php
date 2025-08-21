<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
                        <li><span>Search results</span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container position-relative">

        <div class="update-loading" wire:loading wire:target.except="add2Cart">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="row"  id="products">

            <h1 class="section-title h3"><span>Search by: "{{ request('query') ?? '' }}"</span></h1>

            <div class="col-lg-12">
                @if(count($products))

                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-sm-6 mb-3" wire:key="{{$product->id}}">
                                @include('incs.product-card')
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-12">
                            {{ $products->links(data :['scrollTo' => '#products']) }}
                        </div>
                    </div>

                @else
                    <p>No products found...</p>
                @endif
            </div>
        </div>
    </div>
</div>
