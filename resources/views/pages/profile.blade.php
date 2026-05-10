@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Profile</h1>
        <div class="psub">Manage your account settings and personal information</div>
    </div>
</div>

<div style="max-width: 600px; display: flex; flex-direction: column; gap: 24px;" class="fi" style="animation-delay: 0.1s;">
    <!-- BASIC INFO -->
    <div class="card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), color-mix(in oklch, var(--primary) 60%, black)); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: var(--primary-foreground); border: 4px solid var(--border);">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size: 20px; font-weight: 700;">{{ $user->name }}</div>
                <div style="color: var(--muted-foreground); font-size: 14px;">{{ $user->roles->pluck('name')->join(', ') ?: 'User' }}</div>
                <button class="btn" style="margin-top: 10px; padding: 4px 12px; font-size: 12px;">Change Avatar</button>
            </div>
        </div>

        <form id="profile-form" onsubmit="updateProfile(event)" style="display: flex; flex-direction: column; gap: 16px;">
            <div class="fg float-outlined">
                <input type="text" id="profile-name" name="name" class="inp" placeholder=" " value="{{ $user->name }}" required>
                <label for="profile-name">Full Name</label>
            </div>
            
            <div class="fg float-outlined">
                <input type="email" id="profile-email" name="email" class="inp" placeholder=" " value="{{ $user->email }}" required>
                <label for="profile-email">Email Address</label>
            </div>

            <div class="fg float-outlined">
                <textarea id="profile-bio" name="bio" class="inp" placeholder=" " rows="3" style="resize: none;">{{ $user->bio ?? '' }}</textarea>
                <label for="profile-bio">Bio</label>
            </div>
            
            <div id="profile-error" style="color: var(--destructive); font-size: 12px; display: none;"></div>
            
            <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                <button type="submit" class="btn p" id="profile-submit-btn">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- SECURITY SECTION -->
    <div class="card" style="padding: 24px;">
        <div style="margin-bottom: 20px;">
            <div style="font-weight: 700; font-size: 16px; margin-bottom: 4px;">Security & Password</div>
            <div style="color: var(--muted-foreground); font-size: 13px;">Update your password to keep your account secure.</div>
        </div>
        
        <form id="password-form" onsubmit="updatePassword(event)" style="display: flex; flex-direction: column; gap: 16px;">
            <div class="fg float-outlined">
                <input type="password" id="current_password" name="current_password" class="inp" placeholder=" " required>
                <label for="current_password">Current Password</label>
            </div>
            
            <div class="frow">
                <div class="fg float-outlined">
                    <input type="password" id="new_password" name="password" class="inp" placeholder=" " required minlength="8">
                    <label for="new_password">New Password</label>
                </div>
                <div class="fg float-outlined">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="inp" placeholder=" " required minlength="8">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
            </div>
            
            <div id="password-error" style="color: var(--destructive); font-size: 12px; display: none;"></div>
            
            <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                <button type="submit" class="btn" id="password-submit-btn">Update Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateProfile(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('profile-submit-btn');
        const err = document.getElementById('profile-error');
        
        const data = {
            name: form.name.value,
            email: form.email.value,
            bio: form.bio.value
        };

        btn.disabled = true;
        btn.innerText = 'Saving...';
        err.style.display = 'none';

        apiFetch('{{ route("profile.update") }}', {
            method: 'PUT',
            body: JSON.stringify(data)
        })
        .then(res => {
            if (res.success) {
                toast('Profile updated successfully');
                // Optionally update sidebar username
                const sbUser = document.querySelector('#sb .uinfo div:first-child');
                if(sbUser) sbUser.innerText = data.name;
            } else {
                err.innerText = res.message || 'An error occurred';
                if(res.errors) {
                    err.innerHTML = Object.values(res.errors).map(e => e.join('<br>')).join('<br>');
                }
                err.style.display = 'block';
            }
        })
        .catch(error => {
            err.innerText = error.message;
            err.style.display = 'block';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Save Changes';
        });
    }

    function updatePassword(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('password-submit-btn');
        const err = document.getElementById('password-error');
        
        const data = {
            current_password: form.current_password.value,
            password: form.password.value,
            password_confirmation: form.password_confirmation.value
        };

        if (data.password !== data.password_confirmation) {
            err.innerText = 'New password and confirmation do not match.';
            err.style.display = 'block';
            return;
        }

        btn.disabled = true;
        btn.innerText = 'Updating...';
        err.style.display = 'none';

        apiFetch('{{ route("profile.password") }}', {
            method: 'PUT',
            body: JSON.stringify(data)
        })
        .then(res => {
            if (res.success) {
                toast('Password updated successfully');
                form.reset();
            } else {
                err.innerText = res.message || 'An error occurred';
                if(res.errors) {
                    err.innerHTML = Object.values(res.errors).map(e => e.join('<br>')).join('<br>');
                }
                err.style.display = 'block';
            }
        })
        .catch(error => {
            err.innerText = error.message;
            err.style.display = 'block';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Update Password';
        });
    }
</script>
@endsection
