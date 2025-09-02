<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary" wire:navigate>Add User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th class="col-2">Name</th>
                            <th class="col-2">Email</th>
                            <th class="col-1">Role</th>
                            <th class="col-2">Created</th>
                            <th class="col-2">Updated</th>
                            <th class="col-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <a class="btn btn-warning btn-circle" href="{{ route('admin.users.edit', $user->id) }}" wire:navigate>
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    @if(auth()->id() != $user->id)
                                        <button class="btn btn-danger btn-circle" wire:click="deleteUser({{ $user->id }})" wire:confirm="Are you sure?" wire:loading.attr="disabled">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                    {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
