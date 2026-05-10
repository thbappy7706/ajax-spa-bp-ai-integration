<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ThbPlate — @yield('title', 'Admin Dashboard')</title>
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Syne:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nexus.css') }}">
    @stack('styles')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- TOP PROGRESS BAR -->
<div id="page-loader"></div>

<!-- SIDEBAR -->
@include('layouts.sidebar')

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

<!-- ════ DRAWER ════ -->
<div class="drawer-bg" id="drawer-bg" onclick="closeDrawer()"></div>
<div class="drawer" id="drawer">
    <div class="drawer-header">
        <div class="drawer-title" id="drawer-title">Drawer Title</div>
        <button onclick="closeDrawer()" style="background:none;border:none;cursor:pointer;color:var(--tm);font-size:18px;">×</button>
    </div>
    <div class="drawer-body" id="drawer-body"></div>
    <div class="drawer-footer" id="drawer-footer"></div>
</div>

<!-- ════ TOASTER ════ -->
<div id="toaster-container"></div>

<script>
    // ── CSRF SETUP ──
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── DRAWER HELPERS ──
    function openDrawer(title, bodyHtml, footerHtml = '') {
        document.getElementById('drawer-title').textContent = title;
        document.getElementById('drawer-body').innerHTML = bodyHtml;
        document.getElementById('drawer-footer').innerHTML = footerHtml;
        document.getElementById('drawer-bg').classList.add('open');
        document.getElementById('drawer').classList.add('open');
    }

    function closeDrawer() {
        document.getElementById('drawer-bg').classList.remove('open');
        document.getElementById('drawer').classList.remove('open');
    }

    // ── MODAL HELPERS ──
    function openModal(title, bodyHtml, footerHtml = '', xl = false) {
        const widthClass = xl ? 'style="width: 800px; max-width: 95vw;"' : '';
        const modalHtml = `
            <div class="modal fi" ${widthClass}>
                <div class="mtitle">
                    <span>${title}</span>
                    <button onclick="closeModal(this)" style="background:none;border:none;cursor:pointer;color:var(--tm);font-size:18px;">×</button>
                </div>
                <div class="mbody" style="margin-bottom: 20px;">
                    ${bodyHtml}
                </div>
                <div class="mfooter" style="display:flex;justify-content:flex-end;gap:10px;">
                    ${footerHtml}
                </div>
            </div>
        `;
        const mbg = document.createElement('div');
        mbg.className = 'mbg open auto-modal';
        mbg.innerHTML = modalHtml;
        mbg.onclick = function(e) {
            if(e.target === mbg) closeModal(mbg);
        }
        document.body.appendChild(mbg);
        
        // Find focused elements or first input
        setTimeout(() => {
            const firstInput = mbg.querySelector('input, textarea, select');
            if (firstInput) firstInput.focus();
        }, 100);
    }

    function closeModal(element) {
        const mbg = element.closest('.mbg');
        if (mbg) {
            mbg.querySelector('.modal').style.animation = 'fadeUp 0.15s ease reverse';
            mbg.style.opacity = '0';
            setTimeout(() => mbg.remove(), 150);
        }
    }

    // ── TOASTER HELPER ──
    function toast(msg, type = 'success') {
        const container = document.getElementById('toaster-container');
        const t = document.createElement('div');
        t.className = `toast ${type}`;
        t.innerHTML = `<span>${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}</span> <div>${msg}</div>`;
        container.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateX(20px)';
            t.style.transition = 'all .3s';
            setTimeout(() => t.remove(), 300);
        }, 3000);
    }

    // ── CONFIRMATION HELPER ──
    function confirmAction(msg, onConfirm) {
        const modalHtml = `
            <div class="modal confirm-modal fi" style="width:300px;text-align:center;">
                <div class="mtitle" style="justify-content:center;">Confirm Action</div>
                <div style="font-size:11px;color:var(--tm);margin-bottom:20px;">${msg}</div>
                <div style="display:flex;gap:7px;justify-content:center;">
                    <button class="btn" onclick="document.querySelector('.mbg.confirm-wrap').remove()">Cancel</button>
                    <button class="btn d" id="confirm-btn">Confirm Delete</button>
                </div>
            </div>
        `;
        const mbg = document.createElement('div');
        mbg.className = 'mbg open confirm-wrap';
        mbg.innerHTML = modalHtml;
        document.body.appendChild(mbg);

        mbg.querySelector('#confirm-btn').onclick = () => {
            onConfirm();
            mbg.remove();
        };
    }

    // ── SIDEBAR TOGGLE ──
    function toggleSB() {
        document.getElementById('sb').classList.toggle('col');
        document.getElementById('main').classList.toggle('exp');
    }

    // ── DARK MODE ──
    let isDark = true;

    function applyTheme(dark) {
        const root = document.documentElement;
        if (dark) {
            root.setAttribute('data-theme', 'dark');
            root.classList.add('dark');
        } else {
            root.setAttribute('data-theme', 'light');
            root.classList.remove('dark');
        }
        document.getElementById('dtgl').classList.toggle('on', dark);
    }

    function toggleDark() {
        isDark = !isDark;
        applyTheme(isDark);
    }

    // Apply on load (default: dark)
    applyTheme(isDark);

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
                    document.title = 'ThbPlate — ' + (active.dataset.title || 'Admin');
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
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
