<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.filters.create') }}" class="btn btn-primary" wire:navigate>Add Filter</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th class="col-5">Title</th>
                            <th class="col-5">Filter Group</th>
                            <th class="col-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filters as $filter)
                            <tr wire:key="{{ $filter->id }}">
                                <td>{{ $filter->id }}</td>
                                <td>{{ $filter->title }}</td>
                                <td>{{ $filter->group->title }}</td>
                                <td>
                                    <a class="btn btn-warning btn-circle" href="{{ route('admin.filters.edit', $filter->id) }}" wire:navigate>
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button class="btn btn-danger btn-circle" wire:click="deleteFilter({{ $filter->id }})" wire:confirm="Are you sure?" wire:loading.attr="disabled">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $filters->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
