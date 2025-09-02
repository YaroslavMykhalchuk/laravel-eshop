<div class="row">
    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target="save">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary" wire:navigate>Users List</a>
            </div>
            <div class="card-body">
                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" wire:model="name"
                               required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" wire:model="email"
                               required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" wire:model="password"
                               required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_admin" wire:model.live="is_admin" >
                            <label class="custom-control-label" for="is_admin">{{ $is_admin ? 'Admin' : 'User' }}</label>
                            @error('is_admin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
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
