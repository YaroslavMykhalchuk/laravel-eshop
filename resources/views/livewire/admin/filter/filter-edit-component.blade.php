<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target="save">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.filters.index') }}" class="btn btn-primary" wire:navigate>Filters List</a>
            </div>
            <div class="card-body">
                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Filter group title" wire:model="title"
                               required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label required">Filter Group</label>
                        <select wire:model="filter_group_id" id="filter_group_id" class="custom-select @error('filter_group_id') is-invalid @enderror">
                            <option value="">Select filter group</option>
                            @foreach($filter_groups as $filter_group)
                                <option value="{{ $filter_group->id }}" wire:key="{{ $filter_group->id }}">{{ $filter_group->title }}</option>
                            @endforeach
                        </select>
                        @error('filter_group_id.*')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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
