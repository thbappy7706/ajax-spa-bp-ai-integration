@extends('layouts.app')

@section('title', 'Appearance')
@section('page-title', 'Appearance')
@section('page-sub', 'Customize the look and feel of your dashboard')

@section('content')
<div style="max-width: 600px; display: flex; flex-direction: column; gap: 24px;" class="fi">
    <!-- THEME SECTION -->
    <div class="card" style="padding: 20px;">
        <div style="margin-bottom: 16px;">
            <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">Interface Theme</div>
            <div style="color: var(--tm); font-size: 13px;">Select your preferred color scheme for the dashboard.</div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="theme-card" onclick="setTheme('light')" id="theme-light" style="cursor: pointer; padding: 10px; border-radius: 10px; border: 2px solid var(--gb); background: #f8fafc; transition: all .2s;">
                <div style="height: 60px; background: white; border-radius: 6px; border: 1px solid #e2e8f0; padding: 8px; margin-bottom: 8px;">
                    <div style="width: 40%; height: 6px; background: #e2e8f0; border-radius: 99px; margin-bottom: 6px;"></div>
                    <div style="width: 70%; height: 6px; background: #f1f5f9; border-radius: 99px;"></div>
                </div>
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-align: center;">Light Mode</div>
            </div>
            
            <div class="theme-card" onclick="setTheme('dark')" id="theme-dark" style="cursor: pointer; padding: 10px; border-radius: 10px; border: 2px solid var(--ac); background: #0f172a; transition: all .2s;">
                <div style="height: 60px; background: #1e293b; border-radius: 6px; border: 1px solid #334155; padding: 8px; margin-bottom: 8px;">
                    <div style="width: 40%; height: 6px; background: #334155; border-radius: 99px; margin-bottom: 6px;"></div>
                    <div style="width: 70%; height: 6px; background: #0f172a; border-radius: 99px;"></div>
                </div>
                <div style="font-size: 12px; font-weight: 600; color: white; text-align: center;">Dark Mode</div>
            </div>
        </div>
    </div>

    <!-- ACCENT COLOR SECTION -->
    <div class="card" style="padding: 20px;">
        <div style="margin-bottom: 16px;">
            <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">Primary Color</div>
            <div style="color: var(--tm); font-size: 13px;">Choose an accent color to be used across the interface.</div>
        </div>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @php $colors = ['#22d3ee' => 'Cyan', '#a78bfa' => 'Violet', '#f472b6' => 'Pink', '#4ade80' => 'Emerald', '#fbbf24' => 'Amber']; @endphp
            @foreach($colors as $hex => $name)
                <div onclick="setAccent('{{ $hex }}')" class="accent-btn" style="width: 32px; height: 32px; border-radius: 50%; background: {{ $hex }}; cursor: pointer; border: 2px solid transparent; transition: transform .2s;" title="{{ $name }}"></div>
            @endforeach
        </div>
    </div>

    <!-- SIDEBAR STYLE -->
    <div class="card" style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">Compact Sidebar</div>
                <div style="color: var(--tm); font-size: 13px;">Collapse the sidebar to show only icons by default.</div>
            </div>
            <div class="tgl" id="sidebar-tgl" onclick="toggleSidebarPref()">
                <div class="tglk"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function setTheme(t) {
        document.documentElement.setAttribute('data-theme', t);
        document.querySelectorAll('.theme-card').forEach(c => c.style.borderColor = 'var(--gb)');
        document.getElementById('theme-' + t).style.borderColor = 'var(--ac)';
        // Sync the topbar toggle if it exists
        const dtgl = document.getElementById('dtgl');
        if (dtgl) dtgl.classList.toggle('on', t === 'dark');
        toast('Theme updated to ' + t);
    }

    function setAccent(c) {
        document.documentElement.style.setProperty('--ac', c);
        toast('Accent color updated');
    }

    function toggleSidebarPref() {
        toggleSB();
        const tgl = document.getElementById('sidebar-tgl');
        tgl.classList.toggle('on');
    }
    
    // Initial state for toggle
    if (document.getElementById('sb').classList.contains('col')) {
        document.getElementById('sidebar-tgl').classList.add('on');
    }
</script>

<style>
    .accent-btn:hover { transform: scale(1.15); }
    .accent-btn.active { border-color: white !important; }
</style>
@endsection
