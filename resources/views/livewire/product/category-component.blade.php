<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
                        @foreach($breadCrumbs as $breadCrumb_slug => $breadCrumb_title)
                            @if($loop->last)
                                <li><span>{{ $breadCrumb_title }}</span></li>
                            @else
                                <li><a wire:navigate href="{{ route('category', $breadCrumb_slug) }}" wire:navigate>{{ $breadCrumb_title }}</a></li>
                            @endif
                        @endforeach
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
            <div class="col-lg-3 col-md-4">
                <div class="sidebar h-100">

                    <button class="btn btn-warning w-100 text-start collapse-filters-btn mb-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseExample">
                        <i class="fa-solid fa-filter"></i> Filters
                    </button>

                    <div class="collapse collapse-filters" id="collapseFilters">

                        @if($selected_filters)
                            <button class="btn btn-outline-warning mb-3 w-100" wire:click="clearFilters">Clear filters</button>
                            <div class="selected-filters mb-3">
                                @foreach($filter_groups as $filter_group)
                                    @foreach($filter_group as $filter)
                                        @if(in_array($filter->filter_id, $selected_filters))
                                            <p
                                                wire:click="removeFilter({{ $filter->filter_id }})"
                                                wire:key="{{ $filter->filter_id }}">
                                                <i class="fa-solid fa-xmark text-danger "></i>
                                                {{ $filter->filter_title }}
                                            </p>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <h5 class="section-title"><span>Filter by Price</span></h5>
                            <div class="filter-price">
                                <input type="number" class="form-control" value="{{ $min_price }}" wire:model.live.debounce.500ms="min_price">
                                <input type="number" class="form-control" value="{{ $max_price }}" wire:model.live.debounce.500ms="max_price">
                            </div>
                        </div>
                        @foreach($filter_groups as $k => $filter_group)
                            <div class="filter-block" wire:key="{{ $k }}">
                                <h5 class="section-title"><span>Filter by {{ $filter_group[0]->title }}</span></h5>
                                @foreach($filter_group as $filter)
                                    <div class="form-check d-flex justify-content-between" wire:key="{{ $filter->filter_id }}">
                                        <div>
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value="{{ $filter->filter_id }}"
                                                id="{{ $filter->filter_id }}"
                                                wire:model.live="selected_filters">
                                            <label class="form-check-label" for="{{ $filter->filter_id }}">
                                                {{ $filter->filter_title }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="row mb-3">
                    <div class="col-12">
                        <h1 class="section-title h3"><span>{{ $category->title }}</span></h1>
                    </div>
                </div>



                @if(count($products))
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Sort By:</span>
                                <select class="form-select" aria-label="Sort by:" wire:change="changeSort" wire:model="sort">
                                    @foreach($sortList as $k => $item)
                                        <option value="{{ $k }}" @if($k === $sort) selected @endif wire:key="{{ $k }}">{{ $item['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Show:</span>
                                <select class="form-select" aria-label="Show:" wire:change="changeLimit" wire:model="limit">
                                    @foreach($limitList as $k => $item)
                                        <option value="{{ $item }}" @if($k == $limit) selected @endif wire:key="{{ $k }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-sm-6 mb-3" wire:key="{{$product->id}}">
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
