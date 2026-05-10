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
            <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:14px;letter-spacing:-.2px;">THBPLATE</div>
            <div style="font-size:11px;color:var(--tm);">Admin Console</div>
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

        <div class="slbl">Management</div>
        <a class="ni {{ request()->routeIs('users') ? 'active' : '' }}" href="{{ route('users') }}"
           data-route="{{ route('users') }}" data-title="Users" data-sub="Manage user accounts">
            <span class="ni-ic">⬟</span><span class="nl">Users</span>
        </a>
        <a class="ni {{ request()->routeIs('roles') ? 'active' : '' }}" href="{{ route('roles') }}"
           data-route="{{ route('roles') }}" data-title="Roles" data-sub="Manage roles and permissions">
            <span class="ni-ic">🛡</span><span class="nl">Roles</span>
        </a>
        <a class="ni {{ request()->routeIs('products') || request()->routeIs('products.*') ? 'active' : '' }}"
           href="{{ route('products') }}" data-route="{{ route('products') }}" data-title="Products"
           data-sub="Manage products — create, read, update, delete">
            <span class="ni-ic">◉</span><span class="nl">Products</span>
        </a>
        <div class="slbl">CMS</div>
        <a class="ni {{ request()->routeIs('categories') || request()->routeIs('categories.*') ? 'active' : '' }}"
           href="{{ route('categories.index') }}" data-route="{{ route('categories.index') }}" data-title="Categories"
           data-sub="Manage post categories">
            <span class="ni-ic">📁</span><span class="nl">Categories</span>
        </a>
        <a class="ni {{ request()->routeIs('posts') || request()->routeIs('posts.*') ? 'active' : '' }}"
           href="{{ route('posts.index') }}" data-route="{{ route('posts.index') }}" data-title="Posts"
           data-sub="Manage blog posts">
            <span class="ni-ic">📝</span><span class="nl">Posts</span>
        </a>
        <a class="ni {{ request()->routeIs('comments') || request()->routeIs('comments.*') ? 'active' : '' }}"
           href="{{ route('comments.index') }}" data-route="{{ route('comments.index') }}" data-title="Comments"
           data-sub="Manage user comments">
            <span class="ni-ic">💬</span><span class="nl">Comments</span>
        </a>

        <div class="slbl">Preferences</div>
        <a class="ni {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}"
           data-route="{{ route('profile') }}" data-title="Profile" data-sub="Manage your personal information">
            <span class="ni-ic">👤</span><span class="nl">Profile</span>
        </a>
        <a class="ni {{ request()->routeIs('appearance') ? 'active' : '' }}" href="{{ route('appearance') }}"
           data-route="{{ route('appearance') }}" data-title="Appearance" data-sub="Customize your theme and layout">
            <span class="ni-ic">🎨</span><span class="nl">Appearance</span>
        </a>
    </nav>

    <div style="padding:7px;border-top:1px solid var(--gb);display:flex;flex-direction:column;gap:4px;">
        <div
            style="display:flex;align-items:center;gap:7px;padding:5px;border-radius:8px;cursor:pointer;transition:background .15s;"
            onmouseenter="this.style.background='var(--gs)'" onmouseleave="this.style.background='transparent'">
            <div
                style="width:26px;height:26px;border-radius:7px;background:linear-gradient(135deg,#22d3ee22,#a78bfa22);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;border:1px solid var(--gb);">
                AR
            </div>
            <div class="uinfo" style="overflow:hidden;">
                <div style="font-size:14px;font-weight:600;white-space:nowrap;">Alex Rivera</div>
                <div style="font-size:11px;color:var(--tm);white-space:nowrap;">Super Admin</div>
            </div>
        </div>
        
        <a class="ni" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:var(--ac3);">
            <span class="ni-ic">⏻</span><span class="nl">Logout</span>
        </a>
    </div>
</aside>
