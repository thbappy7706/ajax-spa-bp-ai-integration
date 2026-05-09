@extends('auth.layout')
@section('title', 'Sign In')

@section('auth-content')
    <h1 class="auth-heading">Welcome back</h1>
    <p class="auth-sub">Sign in to your Laravel BladeAJX account to continue.</p>

    {{-- Session / Validation Errors --}}
    @if(session('status'))
        <div class="alert alert-success">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="7" stroke="#10b981" stroke-width="1.3"/>
                <path d="M5 8l2.5 2.5L11 5.5" stroke="#10b981" stroke-width="1.3" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="7" stroke="#f43f5e" stroke-width="1.3"/>
                <path d="M8 5v4M8 10.5v.5" stroke="#f43f5e" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="2" y="4" width="14" height="10" rx="2"
                                                                          stroke="currentColor" stroke-width="1.3"/><path
                d="M2 6l7 5 7-5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      </span>
                <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com"
                       value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>
            @error('email')
            <p class="field-error">
                <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/>
                    <path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/>
                </svg>
                {{ $message }}
            </p>@enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="4" y="8" width="10" height="7" rx="1.5"
                                                                          stroke="currentColor" stroke-width="1.3"/><path
                d="M6 8V6a3 3 0 016 0v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="9"
                                                                                                                  cy="11.5"
                                                                                                                  r="1"
                                                                                                                  fill="currentColor"/></svg>
      </span>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required
                       autocomplete="current-password">
                <button type="button" class="pwd-toggle" onclick="togglePwd(this)" tabindex="-1"
                        aria-label="Show password">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                        <path d="M1 10s3.5-7 9-7 9 7 9 7-3.5 7-9 7S1 10 1 10Z" stroke="currentColor"
                              stroke-width="1.4"/>
                        <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                </button>
            </div>
            @error('password')
            <p class="field-error">
                <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                    <circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/>
                    <path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/>
                </svg>
                {{ $message }}
            </p>@enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="form-group" style="display:flex;align-items:center;justify-content:space-between;">
            <label class="form-check">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Remember me</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary">
            <span class="btn-text">Sign In</span>
        </button>
    </form>

    <div class="divider"><span>or continue with</span></div>

    <div class="social-row">
        <a href="#" class="btn-social">
            <svg width="16" height="16" viewBox="0 0 24 24">
                <path
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                    fill="#4285F4"/>
                <path
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                    fill="#34A853"/>
                <path
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                    fill="#FBBC05"/>
                <path
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                    fill="#EA4335"/>
            </svg>
            Google
        </a>
        <a href="#" class="btn-social">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.335-1.755-1.335-1.755-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
            </svg>
            GitHub
        </a>
    </div>

    <p class="auth-switch">
        Don't have an account? <a href="{{ route('register') }}">Create one →</a>
    </p>
@endsection
