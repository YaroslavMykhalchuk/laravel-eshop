<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary" wire:navigate>Categories List</a>
            </div>
            <div class="card-body">
                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Category title" wire:model="title"
                               required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label required">Parent category</label>
                        <select wire:model="parent_id" id="parent_id" class="form-control form-select @error('parent_id') is-invalid @enderror">
                            <option value="0" wire:key="0">Without subcategory</option>
                            {!! \App\Helpers\Category\Category::getMenu('incs.menu-select-tpl') !!}
                        </select>
                        @error('parent_id')
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
