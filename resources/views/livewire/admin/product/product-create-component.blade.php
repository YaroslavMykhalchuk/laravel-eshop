<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target="save, category_id">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary" wire:navigate>Products List</a>
            </div>
            <div class="card-body">
                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Product title" wire:model="title"
                               required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Category</label>
                        <select wire:model.live="category_id" id="category_id" class="form-control form-select @error('category_id') is-invalid @enderror">
                            <option value="">Select category</option>
                            {!! \App\Helpers\Category\Category::getMenu('incs.menu-select-tpl') !!}
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">
                        @foreach($this->filters as $k => $filter_group)
                            <div class="col-lg-3 col-md-f" wire:key="{{ $k }}">
                                <div class="card">
                                    <div class="card-header py-3">
                                        <h6 class="font-weight-bold text-primary m-0">{{ $filter_group[0]->title }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($filter_group as $filter)
                                            <div wire:key="{{ $filter->filter_id }}">
                                                <input
                                                    type="checkbox"
                                                    wire:model="selectedFilters"
                                                    value="{{ $filter->filter_id }}"
                                                    id="filter-{{ $filter->filter_id }}">
                                                <label for="filter-{{ $filter->filter_id }}" class="form-check-label">{{ $filter->filter_title }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label required">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Product price" wire:model="price"
                               required>
                        @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="old_price" class="form-label">Old price</label>
                        <input type="number" class="form-control @error('old_price') is-invalid @enderror" id="old_price" placeholder="Product old price" wire:model="old_price">
                        @error('old_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" class="@error('is_hit') is-invalid @enderror" id="is_hit" wire:model="is_hit">
                        <label for="is_hit" class="form-check-label">Is hit</label>
                        @error('is_hit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="checkbox" class="@error('is_new') is-invalid @enderror" id="is_new" wire:model="is_new">
                        <label for="is_new" class="form-check-label">Is new</label>
                        @error('is_new')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <input type="text" class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" placeholder="Product excerpt" wire:model="excerpt">
                        @error('excerpt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label required">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="8" placeholder="Product content" wire:model="content"></textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" wire:model="image">
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <div wire:loading wire:target="image"><span class="text-success">Uploading...</span></div>

                        @if(!$errors->has('image') && $image && $image->isPreviewable())
                            <p class="text-danger">Click on the photo to delete it.</p>
                            <img
                                src="{{ $image->temporaryUrl() }}"
                                alt=""
                                width="100px"
                                wire:click="removeUpload('image', '{{ $image->getFilename() }}')"
                                style="cursor:pointer;">
                        @endif

                    </div>

                    <div class="mb-3">
                        <label for="gallery" class="form-label">Gallery</label>
                        <input
                            id="gallery"
                            type="file"
                            class="form-control-file @error('gallery.*') is-invalid @enderror"
                            wire:model="gallery"
                            placeholder="Gallery"
                            multiple>
                        @error('gallery')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <div wire:loading wire:target="gallery"><span class="text-success">Uploading...</span></div>

                        @if($gallery)
                            <p class="text-danger">Click on the photo to delete it.</p>
                            <div class="mt-2">
                                @foreach($gallery as $photo)
                                    @if($photo->isPreviewable())
                                        <img
                                            src="{{ $photo->temporaryUrl() }}"
                                            alt=""
                                            width="100px"
                                            wire:click="removeUpload('gallery', '{{ $photo->getFilename() }}')"
                                            style="cursor:pointer;">
                                    @else
                                        <span class="text-danger">Error!</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">
                            Save
                            <div wire:loading wire:target="save" class="spinner-grow spinner-grow-sm" role="status" style="margin-bottom: 3px;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
