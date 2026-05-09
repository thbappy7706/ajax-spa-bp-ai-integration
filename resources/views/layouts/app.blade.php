<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexus — @yield('title', 'Admin Dashboard')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #080c14;
            --surface: rgba(255, 255, 255, .05);
            --gb: rgba(255, 255, 255, .09);
            --gs: rgba(255, 255, 255, .07);
            --ac: #22d3ee;
            --ac2: #a78bfa;
            --ac3: #f472b6;
            --tp: #e8eeff;
            --tm: rgba(155, 175, 210, .65);
            --sw: 210px;
            --sc: 52px;
        }

        [data-theme="light"] {
            --bg: #edf1f8;
            --surface: rgba(255, 255, 255, .55);
            --gb: rgba(100, 130, 200, .16);
            --gs: rgba(255, 255, 255, .7);
            --tp: #111827;
            --tm: #6b7a99;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--tp);
            min-height: 100vh;
            overflow-x: hidden;
            font-size: 11px;
            transition: background .4s, color .4s;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background: radial-gradient(ellipse 80% 60% at 10% 10%, rgba(34, 211, 238, .07) 0%, transparent 60%), radial-gradient(ellipse 60% 50% at 90% 80%, rgba(167, 139, 250, .09) 0%, transparent 60%), radial-gradient(ellipse 50% 40% at 50% 50%, rgba(244, 114, 182, .05) 0%, transparent 70%);
        }

        ::-webkit-scrollbar {
            width: 3px;
            height: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gb);
            border-radius: 99px;
        }

        .glass {
            background: var(--gs);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--gb);
        }

        .card {
            background: var(--surface);
            backdrop-filter: blur(16px) saturate(160%);
            border: 1px solid var(--gb);
            border-radius: 11px;
            transition: background .2s, border-color .2s;
        }

        .card:hover {
            background: rgba(255, 255, 255, .08);
            border-color: rgba(255, 255, 255, .14);
        }

        [data-theme="light"] .card:hover {
            background: rgba(255, 255, 255, .9);
        }

        /* SIDEBAR */
        #sb {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            width: var(--sw);
            display: flex;
            flex-direction: column;
            transition: width .28s cubic-bezier(.4, 0, .2, 1);
        }

        #sb.col {
            width: var(--sc);
        }

        #sb.col .nl, .ltxt, .uinfo, .slbl {
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        #sb.col .ni {
            justify-content: center;
            padding: 6px;
        }

        #sb.col .larea {
            padding: 12px 8px;
            justify-content: center;
        }

        #sb.col .uinfo {
            display: none;
        }

        .larea {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 12px 12px 10px;
            border-bottom: 1px solid var(--gb);
        }

        .ltxt {
            transition: opacity .2s, width .28s;
            overflow: hidden;
        }

        .slbl {
            font-size: 9px;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--tm);
            padding: 9px 7px 2px;
            transition: opacity .2s, width .28s;
            overflow: hidden;
            white-space: nowrap;
        }

        .ni {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 9px;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s, color .15s;
            color: var(--tm);
            font-size: 10.5px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-decoration: none;
        }

        .ni:hover {
            background: var(--gs);
            color: var(--tp);
        }

        .ni.active {
            background: rgba(34, 211, 238, .11);
            color: var(--ac);
            border: 1px solid rgba(34, 211, 238, .18);
        }

        .ni-ic {
            font-size: 12px;
            min-width: 14px;
            text-align: center;
            flex-shrink: 0;
        }

        .nl {
            transition: opacity .2s, width .28s;
            overflow: hidden;
        }

        #cbb {
            position: absolute;
            right: -11px;
            top: 20px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            z-index: 10;
            transition: transform .28s;
        }

        #sb.col #cbb {
            transform: rotate(180deg);
        }

        #main {
            margin-left: var(--sw);
            transition: margin-left .28s cubic-bezier(.4, 0, .2, 1);
            padding: 16px;
            position: relative;
            z-index: 1;
        }

        #main.exp {
            margin-left: var(--sc);
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ptitle {
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: -.3px;
        }

        .psub {
            font-size: 9px;
            color: var(--tm);
            margin-top: 1px;
        }

        /* STATS */
        .sgrid {
            display: grid;
            grid-template-columns:repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .sc {
            padding: 12px 14px;
        }

        .slb {
            font-size: 9px;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--tm);
            margin-bottom: 6px;
        }

        .sv {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 700;
        }

        .bdg {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 1px 6px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 600;
        }

        .bu {
            background: rgba(34, 211, 238, .11);
            color: var(--ac);
        }

        .bd {
            background: rgba(244, 114, 182, .11);
            color: var(--ac3);
        }

        .bg {
            background: rgba(74, 222, 128, .11);
            color: #4ade80;
        }

        /* CHARTS */
        .mgrid {
            display: grid;
            grid-template-columns:1fr minmax(0, 260px);
            gap: 10px;
            margin-bottom: 16px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            font-size: 9px;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--tm);
            padding: 0 6px 7px 0;
            text-align: left;
            font-weight: 500;
            white-space: nowrap;
        }

        td {
            padding: 6px 6px 6px 0;
            font-size: 10.5px;
            border-top: 1px solid var(--gb);
            vertical-align: middle;
        }

        tr:first-child td {
            border-top: none;
        }

        .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }

        /* TOGGLE */
        .tgl {
            width: 32px;
            height: 18px;
            border-radius: 999px;
            position: relative;
            cursor: pointer;
            transition: background .3s;
            border: 1px solid var(--gb);
        }

        .tglk {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            transition: transform .3s;
        }

        .tgl.on {
            background: var(--ac);
            border-color: var(--ac);
        }

        .tgl.on .tglk {
            transform: translateX(14px);
        }

        /* AVATAR */
        .avs {
            display: flex;
        }

        .av {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--bg);
            margin-left: -5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 700;
        }

        .av:first-child {
            margin-left: 0;
        }

        /* SPARKLINE */
        .spark {
            fill: none;
            stroke-width: 1.4;
        }

        .prog-bar {
            height: 3px;
            background: var(--gb);
            border-radius: 99px;
            overflow: hidden;
            margin-top: 3px;
        }

        .prog-fill {
            height: 100%;
            border-radius: 99px;
        }

        /* INPUT */
        .inp {
            background: var(--surface);
            border: 1px solid var(--gb);
            border-radius: 7px;
            color: var(--tp);
            font-family: 'DM Sans', sans-serif;
            font-size: 10.5px;
            padding: 4px 9px;
            outline: none;
            transition: border-color .15s;
        }

        .inp:focus {
            border-color: var(--ac);
        }

        .inp::placeholder {
            color: var(--tm);
        }

        select.inp {
            cursor: pointer;
        }

        textarea.inp {
            line-height: 1.5;
        }

        /* BTN */
        .btn {
            padding: 4px 10px;
            border-radius: 7px;
            font-size: 10px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            transition: all .15s;
            border: 1px solid var(--gb);
            background: var(--surface);
            color: var(--tm);
        }

        .btn:hover {
            background: var(--gs);
            color: var(--tp);
        }

        .btn:disabled {
            opacity: .35;
            cursor: default;
        }

        .btn.p {
            background: rgba(34, 211, 238, .12);
            border-color: rgba(34, 211, 238, .28);
            color: var(--ac);
        }

        .btn.p:hover {
            background: rgba(34, 211, 238, .2);
        }

        .btn.d {
            background: rgba(244, 114, 182, .10);
            border-color: rgba(244, 114, 182, .22);
            color: var(--ac3);
        }

        .btn.d:hover {
            background: rgba(244, 114, 182, .18);
        }

        /* MODAL */
        .mbg {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 200;
            background: rgba(0, 0, 0, .5);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        .mbg.open {
            display: flex;
        }

        .modal {
            background: rgba(10, 16, 28, .97);
            border: 1px solid var(--gb);
            border-radius: 13px;
            padding: 18px 20px;
            width: 400px;
            max-width: 95vw;
            backdrop-filter: blur(30px);
        }

        [data-theme="light"] .modal {
            background: rgba(240, 245, 255, .97);
        }

        .mtitle {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .frow {
            display: grid;
            grid-template-columns:1fr 1fr;
            gap: 8px;
            margin-bottom: 8px;
        }

        .fg {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .fg label {
            font-size: 9px;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--tm);
        }

        .fg .inp {
            width: 100%;
        }

        /* DATATABLE */
        .dtc {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .sic::after {
            content: '⇅';
            font-size: 8px;
            margin-left: 2px;
            opacity: .45;
        }

        .sic.asc::after {
            content: '▲';
            opacity: .7;
        }

        .sic.desc::after {
            content: '▼';
            opacity: .7;
        }

        th.st {
            cursor: pointer;
            user-select: none;
        }

        th.st:hover {
            color: var(--tp);
        }

        .pb {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-size: 9px;
            cursor: pointer;
            border: 1px solid var(--gb);
            background: var(--surface);
            color: var(--tm);
            transition: all .15s;
        }

        .pb:hover, .pb.act {
            background: rgba(34, 211, 238, .11);
            border-color: rgba(34, 211, 238, .25);
            color: var(--ac);
        }

        .pb:disabled {
            opacity: .3;
            cursor: default;
        }

        /* SPA LOADER */
        #page-loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            z-index: 9999;
            background: linear-gradient(90deg, var(--ac), var(--ac2), var(--ac3));
            animation: loadbar 1s ease infinite;
        }

        @keyframes loadbar {
            0% {
                transform: scaleX(0) translateX(0);
                transform-origin: left;
            }
            50% {
                transform: scaleX(.7) translateX(20%);
                transform-origin: left;
            }
            100% {
                transform: scaleX(1) translateX(0);
                transform-origin: left;
                opacity: 0;
            }
        }

        /* CONTENT AREA */
        #content-area {
            min-height: 60vh;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(14px)
            }
            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(7px)
            }
            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fi {
            animation: fadeUp .22s ease both;
        }

        @media (max-width: 768px) {
            #sb {
                width: var(--sc) !important;
            }

            #sb .nl, #sb .ltxt, #sb .uinfo, #sb .slbl {
                opacity: 0 !important;
                width: 0 !important;
            }

            #sb .ni {
                justify-content: center;
                padding: 6px;
            }

            #sb .larea {
                justify-content: center;
            }

            #main {
                margin-left: var(--sc) !important;
                padding: 10px;
            }

            .mgrid {
                grid-template-columns:1fr !important;
            }

            .frow {
                grid-template-columns:1fr !important;
            }
        }
    </style>
</head>
<body>

<!-- TOP PROGRESS BAR -->
<div id="page-loader"></div>

<!-- SIDEBAR -->
<aside id="sb" class="glass">
    <div id="cbb" class="glass" onclick="toggleSB()" style="color:var(--tm);">
        <svg width="9" height="9" viewBox="0 0 10 10" fill="none">
            <path d="M6.5 1.5L3 5L6.5 8.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="larea">
        <div
            style="width:25px;height:25px;border-radius:7px;background:linear-gradient(135deg,var(--ac),var(--ac2));display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="11" height="11" viewBox="0 0 14 14" fill="none">
                <path d="M2 7L7 2L12 7L7 12L2 7Z" fill="white" fill-opacity=".9"/>
                <circle cx="7" cy="7" r="2.2" fill="white"/>
            </svg>
        </div>
        <div class="ltxt">
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:11px;letter-spacing:-.2px;">NEXUS</div>
            <div style="font-size:8.5px;color:var(--tm);">Admin Console</div>
        </div>
    </div>
    <nav style="flex:1;overflow-y:auto;padding:7px;display:flex;flex-direction:column;gap:1px;">
        <div class="slbl">Overview</div>
        <a class="ni {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
           data-route="{{ route('dashboard') }}" data-title="Dashboard"
           data-sub="Welcome back, Alex. Here's what's happening today.">
            <span class="ni-ic">⬡</span><span class="nl">Dashboard</span>
        </a>
        <a class="ni {{ request()->routeIs('analytics') ? 'active' : '' }}" href="{{ route('analytics') }}"
           data-route="{{ route('analytics') }}" data-title="Analytics" data-sub="Detailed analytics overview">
            <span class="ni-ic">◈</span><span class="nl">Analytics</span>
        </a>
        <a class="ni {{ request()->routeIs('reports') ? 'active' : '' }}" href="{{ route('reports') }}"
           data-route="{{ route('reports') }}" data-title="Reports" data-sub="Generated reports and exports">
            <span class="ni-ic">◷</span><span class="nl">Reports</span>
            <span
                style="width:5px;height:5px;background:var(--ac3);border-radius:50%;margin-left:auto;flex-shrink:0;"></span>
        </a>
        <div class="slbl">Management</div>
        <a class="ni {{ request()->routeIs('users') ? 'active' : '' }}" href="{{ route('users') }}"
           data-route="{{ route('users') }}" data-title="Users" data-sub="Manage user accounts">
            <span class="ni-ic">⬟</span><span class="nl">Users</span>
        </a>
        <a class="ni {{ request()->routeIs('products') || request()->routeIs('products.*') ? 'active' : '' }}"
           href="{{ route('products') }}" data-route="{{ route('products') }}" data-title="Products"
           data-sub="Manage products — create, read, update, delete">
            <span class="ni-ic">◉</span><span class="nl">Products</span>
        </a>
        <a class="ni {{ request()->routeIs('calendar') ? 'active' : '' }}" href="{{ route('calendar') }}"
           data-route="{{ route('calendar') }}" data-title="Calendar" data-sub="Schedule and events">
            <span class="ni-ic">▦</span><span class="nl">Calendar</span>
        </a>
        <div class="slbl">System</div>
        <a class="ni {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}"
           data-route="{{ route('settings') }}" data-title="Settings" data-sub="System configuration">
            <span class="ni-ic">⚙</span><span class="nl">Settings</span>
        </a>
        <a class="ni {{ request()->routeIs('security') ? 'active' : '' }}" href="{{ route('security') }}"
           data-route="{{ route('security') }}" data-title="Security" data-sub="Access control and logs">
            <span class="ni-ic">⬡</span><span class="nl">Security</span>
        </a>
    </nav>
    <div style="padding:7px;border-top:1px solid var(--gb);">
        <div
            style="display:flex;align-items:center;gap:7px;padding:5px;border-radius:8px;cursor:pointer;transition:background .15s;"
            onmouseenter="this.style.background='var(--gs)'" onmouseleave="this.style.background='transparent'">
            <div
                style="width:26px;height:26px;border-radius:7px;background:linear-gradient(135deg,#22d3ee22,#a78bfa22);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;flex-shrink:0;border:1px solid var(--gb);">
                AR
            </div>
            <div class="uinfo" style="overflow:hidden;">
                <div style="font-size:10.5px;font-weight:500;white-space:nowrap;">Alex Rivera</div>
                <div style="font-size:8.5px;color:var(--tm);white-space:nowrap;">Super Admin</div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN -->
<main id="main">
    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <div class="ptitle" id="ph">@yield('page-title', 'Dashboard')</div>
            <div class="psub" id="ps">@yield('page-sub', "Welcome back, Alex. Here's what's happening today.")</div>
        </div>
        <div style="display:flex;align-items:center;gap:7px;flex-wrap:wrap;">
            <div
                style="display:flex;align-items:center;gap:6px;background:var(--surface);border:1px solid var(--gb);border-radius:8px;padding:4px 9px;">
                <svg width="11" height="11" viewBox="0 0 15 15" fill="none" style="opacity:.4;flex-shrink:0;">
                    <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.4"/>
                    <path d="M10.5 10.5L13.5 13.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
                <input type="text" placeholder="Search…" class="inp"
                       style="border:none;background:none;padding:0;width:110px;">
            </div>
            <div onclick="showNotif()"
                 style="position:relative;width:28px;height:28px;display:flex;align-items:center;justify-content:center;cursor:pointer;border-radius:7px;background:var(--surface);border:1px solid var(--gb);">
                <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                    <path d="M8 1.5C5.5 1.5 3.5 3.5 3.5 6v3.5L2 11.5h12L12.5 9.5V6C12.5 3.5 10.5 1.5 8 1.5Z"
                          stroke="currentColor" stroke-width="1.2" fill="none"/>
                    <path d="M6.5 12.5C6.5 13.33 7.17 14 8 14s1.5-.67 1.5-1.5" stroke="currentColor" stroke-width="1.2"
                          stroke-linecap="round"/>
                </svg>
                <span
                    style="position:absolute;top:5px;right:5px;width:5px;height:5px;background:var(--ac3);border-radius:50%;border:1px solid var(--bg);"></span>
            </div>
            <div style="display:flex;align-items:center;gap:4px;">
                <span style="font-size:9px;color:var(--tm);">☀</span>
                <div class="tgl on" id="dtgl" onclick="toggleDark()">
                    <div class="tglk"></div>
                </div>
                <span style="font-size:9px;color:var(--tm);">☽</span>
            </div>
        </div>
    </div>

    <!-- DYNAMIC CONTENT AREA (AJAX loads here) -->
    <div id="content-area" class="fi">
        @yield('content')
    </div>
</main>

<!-- ════ MODAL SLOT (pages can push their modals here) ════ -->
<div id="modal-area">
    @stack('modals')
</div>

<script>
    // ── CSRF SETUP ──
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── SIDEBAR TOGGLE ──
    function toggleSB() {
        document.getElementById('sb').classList.toggle('col');
        document.getElementById('main').classList.toggle('exp');
    }

    // ── DARK MODE ──
    let isDark = true;

    function toggleDark() {
        isDark = !isDark;
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        document.getElementById('dtgl').classList.toggle('on', isDark);
    }

    // ── NOTIFICATION ──
    function showNotif() {
        const n = document.createElement('div');
        n.style.cssText = 'position:fixed;top:14px;right:14px;z-index:9999;padding:10px 14px;border-radius:10px;background:rgba(10,16,28,.97);border:1px solid var(--gb);backdrop-filter:blur(20px);font-size:10px;max-width:220px;animation:slideIn .22s ease;';
        n.innerHTML = `<div style="font-weight:600;margin-bottom:2px;color:var(--ac);font-size:10px;">3 New Notifications</div><div style="color:var(--tm);font-size:9px;">Taylor W. — payment failed<br>Maya L. — upgraded plan<br>System health: 99.98%</div>`;
        document.body.appendChild(n);
        setTimeout(() => {
            n.style.opacity = '0';
            n.style.transition = 'opacity .3s';
            setTimeout(() => n.remove(), 320);
        }, 2500);
    }

    // ── SPA AJAX NAVIGATION ──
    const loader = document.getElementById('page-loader');
    const content = document.getElementById('content-area');
    const titleEl = document.getElementById('ph');
    const subEl = document.getElementById('ps');

    function showLoader() {
        loader.style.display = 'block';
    }

    function hideLoader() {
        loader.style.display = 'none';
    }

    async function navigateTo(url, pushState = true) {
        showLoader();
        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'text/html',
                }
            });
            if (!res.ok) throw new Error('Network response was not ok');
            const html = await res.text();

            // Replace content area
            content.style.opacity = '0';
            content.style.transform = 'translateY(6px)';
            content.style.transition = 'none';

            setTimeout(() => {
                content.innerHTML = html;
                content.style.transition = 'opacity .2s, transform .2s';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';

                // Re-run any inline scripts in the loaded fragment
                content.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    if (oldScript.src) {
                        newScript.src = oldScript.src;
                    } else {
                        newScript.textContent = oldScript.textContent;
                    }
                    oldScript.replaceWith(newScript);
                });

                // Update page title/subtitle from data attributes on active nav link
                const active = document.querySelector('.ni.active');
                if (active) {
                    titleEl.textContent = active.dataset.title || '';
                    subEl.textContent = active.dataset.sub || '';
                    document.title = 'Nexus — ' + (active.dataset.title || 'Admin');
                }

                hideLoader();
            }, 60);

            if (pushState) {
                history.pushState({url}, '', url);
            }
        } catch (err) {
            console.error('SPA navigation error:', err);
            hideLoader();
            // Fallback: full page load
            window.location.href = url;
        }
    }

    // ── INTERCEPT ALL SIDEBAR LINKS ──
    document.querySelectorAll('.ni[data-route]').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.dataset.route || this.href;

            // Update active state
            document.querySelectorAll('.ni').forEach(n => n.classList.remove('active'));
            this.classList.add('active');

            // Update topbar
            titleEl.textContent = this.dataset.title || '';
            subEl.textContent = this.dataset.sub || '';

            navigateTo(url);
        });
    });

    // ── BROWSER BACK/FORWARD ──
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.url) {
            navigateTo(e.state.url, false);
        }
    });

    // ── PUSH INITIAL STATE ──
    history.replaceState({url: window.location.href}, '', window.location.href);
</script>

@stack('scripts')
</body>
</html>
