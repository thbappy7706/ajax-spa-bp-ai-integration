@extends('auth.layout')
@section('title', 'Create Account')

@section('auth-content')
<h1 class="auth-heading">Create account</h1>
<p class="auth-sub">Join Nexus — it's free to get started.</p>

@if($errors->any())
  <div class="alert alert-error">
    <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#f43f5e" stroke-width="1.3"/><path d="M8 5v4M8 10.5v.5" stroke="#f43f5e" stroke-width="1.3" stroke-linecap="round"/></svg>
    <span>{{ $errors->first() }}</span>
  </div>
@endif

<form method="POST" action="{{ route('register') }}">
  @csrf

  {{-- Name --}}
  <div class="form-group">
    <label class="form-label" for="name">Full Name</label>
    <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="6" r="3.2" stroke="currentColor" stroke-width="1.3"/><path d="M2.5 16c0-3.5 2.9-5.5 6.5-5.5s6.5 2 6.5 5.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      </span>
      <input type="text" id="name" name="name" class="form-input" placeholder="Alex Rivera" value="{{ old('name') }}" required autofocus autocomplete="name">
    </div>
    @error('name')<p class="field-error">
      <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/><path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/></svg>
      {{ $message }}
    </p>@enderror
  </div>

  {{-- Email --}}
  <div class="form-group">
    <label class="form-label" for="email">Email Address</label>
    <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="2" y="4" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.3"/><path d="M2 6l7 5 7-5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      </span>
      <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="email">
    </div>
    @error('email')<p class="field-error">
      <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/><path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/></svg>
      {{ $message }}
    </p>@enderror
  </div>

  {{-- Password --}}
  <div class="form-group">
    <label class="form-label" for="password">Password</label>
    <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="4" y="8" width="10" height="7" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M6 8V6a3 3 0 016 0v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="9" cy="11.5" r="1" fill="currentColor"/></svg>
      </span>
      <input type="password" id="password" name="password" class="form-input" placeholder="Min. 8 characters" required autocomplete="new-password" oninput="checkStrength(this.value)">
      <button type="button" class="pwd-toggle" onclick="togglePwd(this)" tabindex="-1" aria-label="Show password">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M1 10s3.5-7 9-7 9 7 9 7-3.5 7-9 7S1 10 1 10Z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.4"/></svg>
      </button>
    </div>
    <div class="pwd-strength-bar">
      <div class="pwd-segment"></div>
      <div class="pwd-segment"></div>
      <div class="pwd-segment"></div>
      <div class="pwd-segment"></div>
    </div>
    <p class="pwd-hint"></p>
    @error('password')<p class="field-error">
      <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/><path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/></svg>
      {{ $message }}
    </p>@enderror
  </div>

  {{-- Confirm Password --}}
  <div class="form-group">
    <label class="form-label" for="password_confirmation">Confirm Password</label>
    <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="4" y="8" width="10" height="7" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M6 8V6a3 3 0 016 0v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M7 12l1.5 1.5L11 10.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Repeat password" required autocomplete="new-password">
      <button type="button" class="pwd-toggle" onclick="togglePwd(this)" tabindex="-1" aria-label="Show password">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M1 10s3.5-7 9-7 9 7 9 7-3.5 7-9 7S1 10 1 10Z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.4"/></svg>
      </button>
    </div>
    @error('password_confirmation')<p class="field-error">
      <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5.5" stroke="#fda4af" stroke-width="1"/><path d="M6 4v3M6 8v.5" stroke="#fda4af" stroke-width="1" stroke-linecap="round"/></svg>
      {{ $message }}
    </p>@enderror
  </div>

  {{-- Terms --}}
  <div class="form-group">
    <label class="form-check">
      <input type="checkbox" name="terms" required>
      <span>I agree to the <a href="#" style="color:var(--accent);text-decoration:none;">Terms</a> &amp; <a href="#" style="color:var(--accent);text-decoration:none;">Privacy Policy</a></span>
    </label>
  </div>

  <button type="submit" class="btn-primary">
    <span class="btn-text">Create Account</span>
  </button>
</form>

<p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in →</a></p>
@endsection
