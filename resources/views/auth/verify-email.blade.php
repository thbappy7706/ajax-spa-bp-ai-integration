@extends('auth.layout')
@section('title', 'Verify Email')

@section('auth-content')
    <div style="text-align:center;margin-bottom:24px;animation:fade-up .5s both;">
        <div
            style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,rgba(14,165,233,.2),rgba(139,92,246,.2));border:1px solid rgba(14,165,233,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                <rect x="3" y="7" width="26" height="18" rx="3" stroke="#0ea5e9" stroke-width="1.5"/>
                <path d="M3 11l13 9 13-9" stroke="#0ea5e9" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
        <h1 class="auth-heading" style="margin-bottom:6px;">Verify your email</h1>
        <p class="auth-sub" style="margin-bottom:0;">We've sent a verification link to your email. Please check your
            inbox and click the link.</p>
    </div>

    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="7" stroke="#10b981" stroke-width="1.3"/>
                <path d="M5 8l2.5 2.5L11 5.5" stroke="#10b981" stroke-width="1.3" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
            A new verification link has been sent to your email.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:12px;">
        @csrf
        <button type="submit" class="btn-primary">
            <span class="btn-text">Resend Verification Email</span>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                style="width:100%;padding:11px;border-radius:10px;background:none;border:1px solid var(--glass-border);color:var(--muted);font-family:'DM Sans',sans-serif;font-size:13px;cursor:pointer;transition:all .2s;margin-top:6px;"
                onmouseover="this.style.background='rgba(255,255,255,.06)'" onmouseout="this.style.background='none'">
            Sign out of this account
        </button>
    </form>
@endsection
