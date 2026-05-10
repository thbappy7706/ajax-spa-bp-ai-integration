@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Dashboard</h1>
        <div class="psub">Welcome back. Here's a live overview of your system.</div>
    </div>
    <div>
        <button class="btn p" onclick="fetchStats()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            Refresh Now
        </button>
    </div>
</div>

{{-- ════ STATS GRID ════ --}}
<div class="sgrid fi" style="animation-delay: 0.1s;">
    {{-- Users --}}
    <div class="card sc">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="slb">Total Users</div>
            <div style="width:28px;height:28px;border-radius:6px;background:rgba(34,211,238,.1);display:flex;align-items:center;justify-content:center;color:#22d3ee;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="sv" id="stat-users">{{ number_format($usersCount) }}</div>
        <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bu">Live</span><span style="font-size:9.5px;color:var(--muted-foreground);">Registered accounts</span></div>
    </div>
    {{-- Categories --}}
    <div class="card sc">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="slb">Categories</div>
            <div style="width:28px;height:28px;border-radius:6px;background:rgba(167,139,250,.1);display:flex;align-items:center;justify-content:center;color:#a78bfa;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
            </div>
        </div>
        <div class="sv" id="stat-categories">{{ number_format($categoriesCount) }}</div>
        <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg" style="background:rgba(167,139,250,.1);color:#a78bfa;">Live</span><span style="font-size:9.5px;color:var(--muted-foreground);">Content groups</span></div>
    </div>
    {{-- Posts --}}
    <div class="card sc">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="slb">Total Posts</div>
            <div style="width:28px;height:28px;border-radius:6px;background:rgba(244,114,182,.1);display:flex;align-items:center;justify-content:center;color:#f472b6;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
        </div>
        <div class="sv" id="stat-posts">{{ number_format($postsCount) }}</div>
        <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bd" style="color:#f472b6;background:rgba(244,114,182,.15);border-color:transparent;">Live</span><span style="font-size:9.5px;color:var(--muted-foreground);">Published & Drafts</span></div>
    </div>
    {{-- Comments --}}
    <div class="card sc">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="slb">Comments</div>
            <div style="width:28px;height:28px;border-radius:6px;background:rgba(74,222,128,.1);display:flex;align-items:center;justify-content:center;color:#4ade80;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
        </div>
        <div class="sv" id="stat-comments">{{ number_format($commentsCount) }}</div>
        <div style="display:flex;align-items:center;gap:5px;margin-top:5px;"><span class="bdg bg">Live</span><span style="font-size:9.5px;color:var(--muted-foreground);">User feedback</span></div>
    </div>
</div>

{{-- ════ CHART GRID ════ --}}
<div class="frow fi" style="animation-delay: 0.2s; margin-bottom: 20px;">
    {{-- Bar Chart --}}
    <div class="card" style="padding:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <div style="font-family:'Inter',sans-serif;font-size:14px;font-weight:600;">System Activity</div>
                <div style="font-size:11px;color:var(--muted-foreground);">Events per timeframe</div>
            </div>
        </div>
        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="activityBarChart"></canvas>
        </div>
    </div>

    {{-- Pie Chart --}}
    <div class="card" style="padding:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <div style="font-family:'Inter',sans-serif;font-size:14px;font-weight:600;">Posts Status Distribution</div>
                <div style="font-size:11px;color:var(--muted-foreground);">Published vs Draft vs Archived</div>
            </div>
        </div>
        <div style="position: relative; height: 200px; width: 100%; display: flex; justify-content: center;">
            <canvas id="postsPieChart"></canvas>
        </div>
    </div>
</div>

{{-- ════ TABLES GRID ════ --}}
<div class="frow fi" style="animation-delay: 0.3s;">
    {{-- Recent Posts Table --}}
    <div class="card" style="padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <div style="font-family:'Inter',sans-serif;font-size:13px;font-weight:600;">Recent Posts</div>
            <a href="{{ route('posts.index') }}" class="btn p spa-link" style="font-size:11px;">View all →</a>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%; text-align: left; border-collapse: collapse;">
                <thead>
                <tr style="border-bottom: 1px solid var(--border);">
                    <th style="padding: 8px 4px; font-size: 11px; color: var(--muted-foreground); font-weight: 500;">Title</th>
                    <th style="padding: 8px 4px; font-size: 11px; color: var(--muted-foreground); font-weight: 500;">Category</th>
                    <th style="padding: 8px 4px; font-size: 11px; color: var(--muted-foreground); font-weight: 500;">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($recentPosts as $post)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 10px 4px; font-size: 13px; font-weight: 500; color: var(--foreground);">{{ Str::limit($post->title, 30) }}</td>
                        <td style="padding: 10px 4px; font-size: 12px; color: var(--muted-foreground);">{{ $post->category ? $post->category->name : 'N/A' }}</td>
                        <td style="padding: 10px 4px;">
                            <span class="bdg {{ $post->status === 'published' ? 'bu' : ($post->status === 'draft' ? 'bg' : 'bd') }}">{{ ucfirst($post->status) }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Comments --}}
    <div class="card" style="padding:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <div style="font-family:'Inter',sans-serif;font-size:13px;font-weight:600;">Recent Comments</div>
            <a href="{{ route('comments.index') }}" class="btn p spa-link" style="font-size:11px;">View all →</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($recentComments as $comment)
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:28px;height:28px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;font-weight:600;">
                        {{ substr($comment->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;">
                            <div style="font-size:12px;font-weight:600;">{{ $comment->user->name ?? 'Anonymous' }}</div>
                            <div style="font-size:10px;color:var(--muted-foreground);">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                        <div style="font-size:12px;color:var(--muted-foreground);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
(function() {
    let barChart = window.dbBarChart;
    let pieChart = window.dbPieChart;

    function initCharts() {
        const rootStyles = getComputedStyle(document.documentElement);
        const primaryColor = 'hsl(210 100% 50%)'; // fallback
        const accentColor = 'hsl(280 80% 60%)'; 
        const textColor = rootStyles.getPropertyValue('--muted-foreground') || '#888';
        const gridColor = rootStyles.getPropertyValue('--border') || '#333';

        // Helper to extract colors if css variables are in oklch
        const chartColors = ['#22d3ee', '#a78bfa', '#f472b6', '#4ade80', '#fbbf24', '#f87171'];

        Chart.defaults.color = textColor;
        Chart.defaults.font.family = 'Inter, sans-serif';

        if (window.dbBarChart) { window.dbBarChart.destroy(); }
        if (window.dbPieChart) { window.dbPieChart.destroy(); }

        const ctxBar = document.getElementById('activityBarChart').getContext('2d');
        window.dbBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Activity',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: chartColors[0] + '80',
                    borderColor: chartColors[0],
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor + '40' }, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                }
            }
        });

        const ctxPie = document.getElementById('postsPieChart').getContext('2d');
        window.dbPieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Published', 'Draft', 'Archived'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: [chartColors[3], chartColors[4], chartColors[5]],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
                }
            }
        });
    }

    // Initialize charts on load
    initCharts();

    // Polling function
    window.fetchStats = function() {
        fetch('{{ route("dashboard.stats") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            // Update cards with animation
            updateCounter('stat-users', data.users);
            updateCounter('stat-posts', data.posts);
            updateCounter('stat-categories', data.categories);
            updateCounter('stat-comments', data.comments);

            // Update charts
            if (window.dbBarChart) {
                window.dbBarChart.data.datasets[0].data = data.barData;
                window.dbBarChart.update();
            }
            if (window.dbPieChart) {
                window.dbPieChart.data.datasets[0].data = data.pieData;
                window.dbPieChart.update();
            }
        });
    }

    function updateCounter(id, val) {
        const el = document.getElementById(id);
        if(el && el.innerText !== val.toLocaleString()) {
            el.innerText = val.toLocaleString();
            el.style.transform = 'scale(1.1)';
            el.style.color = 'var(--primary)';
            setTimeout(() => {
                el.style.transform = 'scale(1)';
                el.style.color = '';
            }, 300);
        }
    }

    // Poll every 10 seconds
    const pollInterval = setInterval(window.fetchStats, 10000);

    // Initial fetch to populate real chart data immediately
    window.fetchStats();

    // Clean up interval when navigating away in SPA
    document.addEventListener('spa:navigated', () => {
        clearInterval(pollInterval);
    }, { once: true });
})();
</script>

<style>
    .sv { transition: transform 0.3s ease, color 0.3s ease; display: inline-block; }
</style>
@endsection
