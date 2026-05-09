@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-sub', "Welcome back, Alex. Here's what's happening today.")

@section('content')
    {{-- ════ STATS GRID ════ --}}
    <div class="sgrid">
        {{-- Revenue --}}
        <div class="card sc">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                <div class="slb">Total Revenue</div>
                <div
                    style="width:23px;height:23px;border-radius:6px;background:rgba(34,211,238,.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 15 15" fill="none">
                        <path d="M7.5 1L13 4.5V10.5L7.5 14L2 10.5V4.5L7.5 1Z" stroke="#22d3ee" stroke-width="1.3"/>
                    </svg>
                </div>
            </div>
            <div class="sv">$84,294</div>
            <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span
                    class="bdg bu">▲ 12.4%</span><span style="font-size:8.5px;color:var(--tm);">vs last month</span>
            </div>
            <svg width="100%" height="24" viewBox="0 0 200 24" style="margin-top:7px;">
                <defs>
                    <linearGradient id="g1" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#22d3ee" stop-opacity=".22"/>
                        <stop offset="100%" stop-color="#22d3ee" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M0,20 L25,16 L50,14 L75,10 L100,12 L125,7 L150,4 L175,2 L200,1" class="spark"
                      stroke="#22d3ee"/>
                <path d="M0,20 L25,16 L50,14 L75,10 L100,12 L125,7 L150,4 L175,2 L200,1 L200,24 L0,24Z"
                      fill="url(#g1)"/>
            </svg>
        </div>
        {{-- Active Users --}}
        <div class="card sc">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                <div class="slb">Active Users</div>
                <div
                    style="width:23px;height:23px;border-radius:6px;background:rgba(167,139,250,.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="5" r="2.8" stroke="#a78bfa" stroke-width="1.2"/>
                        <path d="M2 13c0-2.8 2.5-4.5 5.5-4.5s5.5 1.7 5.5 4.5" stroke="#a78bfa" stroke-width="1.2"
                              stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="sv">24,810</div>
            <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bu"
                                                                                       style="background:rgba(167,139,250,.1);color:var(--ac2);">▲ 8.1%</span><span
                    style="font-size:8.5px;color:var(--tm);">vs last month</span></div>
            <svg width="100%" height="24" viewBox="0 0 200 24" style="margin-top:7px;">
                <defs>
                    <linearGradient id="g2" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#a78bfa" stop-opacity=".22"/>
                        <stop offset="100%" stop-color="#a78bfa" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M0,18 L35,14 L70,17 L105,9 L140,11 L170,4 L200,1" class="spark" stroke="#a78bfa"/>
                <path d="M0,18 L35,14 L70,17 L105,9 L140,11 L170,4 L200,1 L200,24 L0,24Z" fill="url(#g2)"/>
            </svg>
        </div>
        {{-- Orders --}}
        <div class="card sc">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                <div class="slb">New Orders</div>
                <div
                    style="width:23px;height:23px;border-radius:6px;background:rgba(244,114,182,.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 15 15" fill="none">
                        <rect x="2" y="2" width="11" height="11" rx="2" stroke="#f472b6" stroke-width="1.2"/>
                        <path d="M5 7.5h5M7.5 5v5" stroke="#f472b6" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="sv">1,429</div>
            <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bd">▼ 3.2%</span><span
                    style="font-size:8.5px;color:var(--tm);">vs last month</span></div>
            <svg width="100%" height="24" viewBox="0 0 200 24" style="margin-top:7px;">
                <defs>
                    <linearGradient id="g3" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#f472b6" stop-opacity=".22"/>
                        <stop offset="100%" stop-color="#f472b6" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M0,10 L40,8 L80,12 L120,7 L160,14 L200,6" class="spark" stroke="#f472b6"/>
                <path d="M0,10 L40,8 L80,12 L120,7 L160,14 L200,6 L200,24 L0,24Z" fill="url(#g3)"/>
            </svg>
        </div>
        {{-- Conversion --}}
        <div class="card sc">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
                <div class="slb">Conversion</div>
                <div
                    style="width:23px;height:23px;border-radius:6px;background:rgba(74,222,128,.1);display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 15 15" fill="none">
                        <path d="M2 10L5.5 6.5L8 9L13 3" stroke="#4ade80" stroke-width="1.3" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="sv">5.74%</div>
            <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bg">▲ 0.6%</span><span
                    style="font-size:8.5px;color:var(--tm);">vs last month</span></div>
            <svg width="100%" height="24" viewBox="0 0 200 24" style="margin-top:7px;">
                <defs>
                    <linearGradient id="g4" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#4ade80" stop-opacity=".22"/>
                        <stop offset="100%" stop-color="#4ade80" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M0,20 L50,17 L100,14 L150,8 L200,3" class="spark" stroke="#4ade80"/>
                <path d="M0,20 L50,17 L100,14 L150,8 L200,3 L200,24 L0,24Z" fill="url(#g4)"/>
            </svg>
        </div>
    </div>

    {{-- ════ CHART + ACTIVITY GRID ════ --}}
    <div class="mgrid">
        {{-- Bar Chart --}}
        <div class="card" style="padding:14px;">
            <div
                style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;flex-wrap:wrap;gap:6px;">
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:11px;font-weight:700;">Revenue Overview</div>
                    <div style="font-size:8.5px;color:var(--tm);">Monthly breakdown</div>
                </div>
                <div style="display:flex;gap:3px;">
                    <button class="btn" onclick="setPd('W',this)">W</button>
                    <button class="btn p" onclick="setPd('M',this)">M</button>
                    <button class="btn" onclick="setPd('Y',this)">Y</button>
                </div>
            </div>
            <div id="cbars" style="display:flex;align-items:flex-end;gap:5px;height:80px;"></div>
            <div id="clbls" style="display:flex;margin-top:4px;"></div>
        </div>

        {{-- Activity Feed --}}
        <div class="card" style="padding:14px;">
            <div style="font-family:'Syne',sans-serif;font-size:11px;font-weight:700;margin-bottom:12px;">Recent
                Activity
            </div>
            @foreach($activity as $item)
                <div style="display:flex;gap:8px;margin-bottom:10px;align-items:flex-start;">
                    <div
                        style="width:22px;height:22px;border-radius:6px;background:{{ $item['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:8px;">{{ $item['icon'] }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:10px;font-weight:500;line-height:1.3;">{{ $item['msg'] }}</div>
                        <div style="font-size:8.5px;color:var(--tm);margin-top:1px;">{{ $item['time'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ════ RECENT ORDERS TABLE ════ --}}
    <div class="card" style="padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <div style="font-family:'Syne',sans-serif;font-size:11px;font-weight:700;">Recent Orders</div>
            <a href="{{ route('products') }}" class="btn p spa-link" data-title="Products" data-sub="Manage products"
               style="font-size:9px;">View all →</a>
        </div>
        <div style="overflow-x:auto;">
            <table style="min-width:420px;">
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $o)
                    <tr onmouseenter="this.style.background='var(--gs)'"
                        onmouseleave="this.style.background='transparent'" style="transition:background .1s;">
                        <td style="font-size:9px;color:var(--tm);">#{{ $o['id'] }}</td>
                        <td style="font-weight:500;">{{ $o['customer'] }}</td>
                        <td style="font-weight:600;">{{ $o['amount'] }}</td>
                        <td>
                            <span
                                style="background:{{ $o['status_bg'] }};color:{{ $o['status_color'] }};padding:1px 6px;border-radius:4px;font-size:8.5px;">{{ $o['status'] }}</span>
                        </td>
                        <td style="color:var(--tm);font-size:9px;">{{ $o['date'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const CD = {
            W: {d: [42, 58, 35, 72, 65, 80, 91], l: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']},
            M: {
                d: [54, 72, 61, 85, 79, 92, 68, 88, 74, 96, 83, 100],
                l: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            Y: {d: [68, 74, 80, 72, 85, 91], l: ['2020', '2021', '2022', '2023', '2024', '2025']}
        };
        const CC = ['#22d3ee', '#a78bfa', '#f472b6', '#4ade80', '#fbbf24', '#22d3ee', '#a78bfa', '#f472b6', '#4ade80', '#fbbf24', '#22d3ee', '#a78bfa'];

        function renderCh(p) {
            const {d, l} = CD[p], mx = Math.max(...d);
            document.getElementById('cbars').innerHTML = d.map((v, i) => `
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;">
      <span style="font-size:8px;color:var(--tm);">${v}</span>
      <div style="width:100%;height:${(v / mx) * 76}px;border-radius:4px 4px 0 0;background:${CC[i % CC.length]}20;border:1px solid ${CC[i % CC.length]}44;position:relative;overflow:hidden;cursor:pointer;" title="${l[i]}: ${v}k">
        <div style="position:absolute;bottom:0;left:0;right:0;height:55%;background:${CC[i % CC.length]}30;"></div>
      </div>
    </div>`).join('');
            document.getElementById('clbls').innerHTML = l.map(x => `<div style="flex:1;text-align:center;font-size:8px;color:var(--tm);">${x}</div>`).join('');
        }

        function setPd(p, btn) {
            document.querySelectorAll('button[onclick^="setPd"]').forEach(b => b.className = 'btn');
            btn.className = 'btn p';
            renderCh(p);
        }

        renderCh('M');

        // Wire "View all" link as SPA
        document.querySelectorAll('.spa-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.ni').forEach(n => n.classList.remove('active'));
                document.querySelectorAll('.ni').forEach(n => {
                    if (n.href === this.href) n.classList.add('active');
                });
                navigateTo(this.href);
            });
        });
    </script>
@endsection
