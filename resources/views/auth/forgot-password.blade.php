@extends('auth.layout')
@section('title', 'Reset Password')

@section('auth-content')
    <h1 class="auth-heading">Forgot password?</h1>
    <p class="auth-sub">Enter your email and we'll send a reset link.</p>

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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="2" y="4" width="14" height="10" rx="2"
                                                                          stroke="currentColor" stroke-width="1.3"/><path
                d="M2 6l7 5 7-5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      </span>
                <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com"
                       value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn-primary">
            <span class="btn-text">Send Reset Link</span>
        </button>
    </form>

    <p class="auth-switch"><a href="{{ route('login') }}">← Back to sign in</a></p>
@endsection
