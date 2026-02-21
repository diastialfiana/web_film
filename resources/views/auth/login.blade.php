@extends('layouts.app')

@section('styles')
<style>
    .login-wrapper {
        min-height: calc(100vh - 72px);
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
        background-size: cover;
        background-position: center;
    }
    .glass-card {
        background: rgba(20, 20, 20, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .form-control {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        padding: 0.75rem 1rem;
        height: auto;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: var(--primary-color) !important;
        box-shadow: none;
    }
    .login-header {
        font-weight: 700;
        letter-spacing: -1px;
    }
</style>
@endsection

@section('content')
</div> <!-- Close default container to let login-wrapper go full width if needed, but we'll stay inside for simplicity or adjust -->
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="glass-card p-5">
                    <div class="text-center mb-5">
                        <h2 class="login-header text-white mb-2">{{ __('app.auth.login') }}</h2>
                        <p class="text-muted">{{ __('app.auth.welcome') }}</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger bg-danger text-white border-0 mb-4 px-3 py-2 small">
                            <ul class="mb-0 list-unstyled text-center">
                                @foreach($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label class="text-white small font-weight-bold mb-2">{{ __('app.auth.username') }}</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="aldmic">
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-white small font-weight-bold mb-2">{{ __('app.auth.password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg mb-4">
                            {{ __('app.auth.login') }}
                        </button>
                        
                        <div class="text-center">
                            <small class="text-muted">{{ __('app.auth.testing_account') }}: <strong>aldmic / 123abc123</strong></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div> <!-- Re-open to balance if necessary, but actually we should handle container better in layout -->
@endsection
