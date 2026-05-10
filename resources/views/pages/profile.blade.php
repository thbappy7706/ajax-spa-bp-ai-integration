@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-sub', 'Manage your account settings and personal information')

@section('content')
<div style="max-width: 600px; display: flex; flex-direction: column; gap: 24px;" class="fi">
    <!-- BASIC INFO -->
    <div class="card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 24px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--ac), var(--ac2)); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: white; border: 4px solid var(--gb);">
                AR
            </div>
            <div>
                <div style="font-size: 20px; font-weight: 700;">Alex Rivera</div>
                <div style="color: var(--tm); font-size: 14px;">Super Administrator</div>
                <button class="btn" style="margin-top: 10px; padding: 4px 12px; font-size: 12px;">Change Avatar</button>
            </div>
        </div>

        <form style="display: flex; flex-direction: column; gap: 16px;">
            <div class="frow">
                <div class="fg">
                    <label>First Name</label>
                    <input type="text" class="inp" value="Alex">
                </div>
                <div class="fg">
                    <label>Last Name</label>
                    <input type="text" class="inp" value="Rivera">
                </div>
            </div>
            <div class="fg">
                <label>Email Address</label>
                <input type="email" class="inp" value="alex@nexus.io">
            </div>
            <div class="fg">
                <label>Bio</label>
                <textarea class="inp" rows="3" style="resize: none;">Senior System Architect & Nexus Core Team Lead.</textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                <button type="button" class="btn p" onclick="toast('Profile updated successfully')">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- SECURITY SECTION -->
    <div class="card" style="padding: 24px;">
        <div style="margin-bottom: 20px;">
            <div style="font-weight: 700; font-size: 16px; margin-bottom: 4px;">Security & Password</div>
            <div style="color: var(--tm); font-size: 13px;">Update your password to keep your account secure.</div>
        </div>
        
        <form style="display: flex; flex-direction: column; gap: 16px;">
            <div class="fg">
                <label>Current Password</label>
                <input type="password" class="inp" placeholder="••••••••">
            </div>
            <div class="frow">
                <div class="fg">
                    <label>New Password</label>
                    <input type="password" class="inp">
                </div>
                <div class="fg">
                    <label>Confirm Password</label>
                    <input type="password" class="inp">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                <button type="button" class="btn" onclick="toast('Password updated')">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
