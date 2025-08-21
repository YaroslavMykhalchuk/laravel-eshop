<div>

    @section('metatags')
        <title>{{ config('app.name') . ' :: ' . ($title ?? 'Page Title') }}</title>
        <meta name="description" content="{{ $desc ?? 'default' }}">
    @endsection

    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
                        <li><span>Login</span></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-12">

                <div class="page-register bg-white p-3">
                    <h1 class="section-title h3"><span>Login</span></h1>

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form wire:submit="login" class="needs-validation" novalidate>

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
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                           placeholder="Password" wire:model="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-warning">
                                        Login
                                        <div wire:loading wire:target="login" class="spinner-grow spinner-grow-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>                                    <a href="{{ route('register') }}" class="not-register nav-link" wire:navigate>Not registered?</a>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
