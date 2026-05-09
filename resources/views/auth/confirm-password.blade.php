@extends('auth.layout')
@section('title', 'Confirm Password')

@section('auth-content')
<div style="text-align:center;margin-bottom:22px;animation:fade-up .4s both;">
  <div style="width:52px;height:52px;border-radius:14px;background:rgba(139,92,246,.15);border:1px solid rgba(139,92,246,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="9" rx="2" stroke="#8b5cf6" stroke-width="1.5"/><path d="M8 11V7a4 4 0 018 0v4" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round"/><circle cx="12" cy="15.5" r="1.2" fill="#8b5cf6"/></svg>
  </div>
  <h1 class="auth-heading" style="margin-bottom:4px;">Confirm password</h1>
  <p class="auth-sub" style="margin-bottom:0;font-size:12px;">This is a secure area. Please confirm your password to continue.</p>
</div>

@if($errors->any())
  <div class="alert alert-error">
    <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#f43f5e" stroke-width="1.3"/><path d="M8 5v4M8 10.5v.5" stroke="#f43f5e" stroke-width="1.3" stroke-linecap="round"/></svg>
    <span>{{ $errors->first() }}</span>
  </div>
@endif

<form method="POST" action="{{ route('password.confirm') }}">
  @csrf
  <div class="form-group">
    <label class="form-label" for="password">Current Password</label>
    <div class="form-input-wrap">
      <span class="form-icon">
        <svg width="15" height="15" viewBox="0 0 18 18" fill="none"><rect x="4" y="8" width="10" height="7" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M6 8V6a3 3 0 016 0v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="9" cy="11.5" r="1" fill="currentColor"/></svg>
      </span>
      <input type="password" id="password" name="password" class="form-input" placeholder="Your current password" required autofocus autocomplete="current-password">
      <button type="button" class="pwd-toggle" onclick="togglePwd(this)" tabindex="-1">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M1 10s3.5-7 9-7 9 7 9 7-3.5 7-9 7S1 10 1 10Z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.4"/></svg>
      </button>
    </div>
    @error('password')<p class="field-error">{{ $message }}</p>@enderror
  </div>

  <button type="submit" class="btn-primary">
    <span class="btn-text">Confirm &amp; Continue</span>
  </button>
</form>
@endsection
