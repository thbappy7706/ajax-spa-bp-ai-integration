<aside id="sb" class="glass">
    <div id="cbb" class="glass" onclick="toggleSB()" style="color:var(--tm);">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
    </div>
    
    <div class="larea">
        <div style="width:28px;height:28px;border-radius:6px;background:var(--primary);color:var(--primary-foreground);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12L12 2L22 12L12 22L2 12Z" />
            </svg>
        </div>
        <div class="ltxt" style="flex:1;">
            <div style="font-family:'Inter',sans-serif;font-weight:600;font-size:14px;line-height:1.2;">ThbPlate Inc</div>
            <div style="font-size:11px;color:var(--muted-foreground);line-height:1.2;">Enterprise Plan</div>
        </div>
        <div class="ltxt">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--muted-foreground)">
                <path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>
            </svg>
        </div>
    </div>

    <nav style="flex:1;overflow-y:auto;padding:10px 8px;display:flex;flex-direction:column;gap:4px;">
        <div class="slbl">Overview</div>
        <a class="ni {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" data-route="{{ route('dashboard') }}" data-title="Dashboard" data-sub="Welcome back, Alex.">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg></div>
            <span class="nl">Dashboard</span>
        </a>
        <a class="ni {{ request()->routeIs('analytics') ? 'active' : '' }}" href="{{ route('analytics') }}" data-route="{{ route('analytics') }}" data-title="Analytics" data-sub="Detailed analytics overview">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg></div>
            <span class="nl">Analytics</span>
        </a>

        <div class="slbl" style="margin-top:10px;">Management</div>
        <a class="ni {{ request()->routeIs('users') ? 'active' : '' }}" href="{{ route('users') }}" data-route="{{ route('users') }}" data-title="Users" data-sub="Manage user accounts">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <span class="nl">Users</span>
        </a>
        <a class="ni {{ request()->routeIs('roles') ? 'active' : '' }}" href="{{ route('roles') }}" data-route="{{ route('roles') }}" data-title="Roles" data-sub="Manage roles and permissions">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <span class="nl">Roles</span>
        </a>
        <a class="ni {{ request()->routeIs('products') || request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products') }}" data-route="{{ route('products') }}" data-title="Products" data-sub="Manage catalog">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></div>
            <span class="nl">Products</span>
        </a>

        <div class="slbl" style="margin-top:10px;">CMS</div>
        <a class="ni {{ request()->routeIs('categories') || request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}" data-route="{{ route('categories.index') }}" data-title="Categories" data-sub="Post categories">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg></div>
            <span class="nl">Categories</span>
        </a>
        <a class="ni {{ request()->routeIs('posts') || request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}" data-route="{{ route('posts.index') }}" data-title="Posts" data-sub="Manage blog posts">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <span class="nl">Posts</span>
        </a>
        <a class="ni {{ request()->routeIs('comments') || request()->routeIs('comments.*') ? 'active' : '' }}" href="{{ route('comments.index') }}" data-route="{{ route('comments.index') }}" data-title="Comments" data-sub="User comments">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
            <span class="nl">Comments</span>
        </a>

        <div class="slbl" style="margin-top:10px;">AI</div>
        <a class="ni {{ request()->routeIs('chat') ? 'active' : '' }}" href="{{ route('chat') }}" data-route="{{ route('chat') }}" data-title="Chat Assistant" data-sub="AI-powered conversation">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M14 12h4"/><path d="M10 12h2"/></svg></div>
            <span class="nl">Chat</span>
        </a>

        <div class="slbl" style="margin-top:10px;">Preferences</div>
        <a class="ni {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}" data-route="{{ route('profile') }}" data-title="Profile" data-sub="Account info">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg></div>
            <span class="nl">Profile</span>
        </a>
        <a class="ni {{ request()->routeIs('appearance') ? 'active' : '' }}" href="{{ route('appearance') }}" data-route="{{ route('appearance') }}" data-title="Appearance" data-sub="Theme configuration">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
            <span class="nl">Appearance</span>
        </a>
    </nav>

    <div style="padding:10px;border-top:1px solid var(--sidebar-border, var(--border));">
        <div style="display:flex;align-items:center;gap:10px;padding:6px;border-radius:6px;cursor:pointer;transition:background .15s;" class="uwrap" onmouseenter="this.style.background='var(--sidebar-accent, var(--accent))'" onmouseleave="this.style.background='transparent'">
            <div style="width:32px;height:32px;border-radius:6px;background:var(--primary);color:var(--primary-foreground);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0;">
                AR
            </div>
            <div class="uinfo" style="flex:1;overflow:hidden;line-height:1.3;">
                <div style="font-size:13px;font-weight:600;white-space:nowrap;color:var(--foreground)">Alex Rivera</div>
                <div style="font-size:11px;color:var(--muted-foreground);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">alex@thbplate.com</div>
            </div>
            <div class="uinfo">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--muted-foreground)"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
            </div>
        </div>
        <a class="ni" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-top:5px;color:var(--destructive);">
            <div class="ni-ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg></div>
            <span class="nl">Log out</span>
        </a>
    </div>
</aside>
