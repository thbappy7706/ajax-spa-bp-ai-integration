
# Laravel SPA (Blade + AJAX)

A full-featured admin dashboard built with **Laravel**, **Blade**, and vanilla **AJAX/fetch** — no Vue, no React, no Inertia. Every sidebar click loads content without a page reload, while the URL updates and the back button works correctly.

---

## Architecture

```
Browser                          Laravel
  │                                  │
  │  GET /dashboard                  │
  │ ─────────────────────────────>   │
  │   (first load, full HTML)        │ layouts/app.blade.php
  │ <─────────────────────────────   │   └─ @yield('content') ← pages/dashboard.blade.php
  │                                  │
  │  click "Products" in sidebar     │
  │ fetch('/products', {             │
  │   headers: {                     │
  │     'X-Requested-With':          │
  │       'XMLHttpRequest'           │
  │   }                              │
  │ })                               │
  │ ─────────────────────────────>   │
  │   (AJAX, content fragment only)  │ ProductController::index()
  │ <─────────────────────────────   │   → view()->renderSections()['content']
  │                                  │
  │  inject into #content-area       │
  │  history.pushState('/products')  │
```

### How it works

1. **Full page load** — first request serves `layouts/app.blade.php` with the full sidebar/topbar and the current page's `@section('content')` injected.
2. **Subsequent navigation** — the SPA JS intercepts clicks on `.ni[data-route]` sidebar links, fetches the URL with `X-Requested-With: XMLHttpRequest`, and the controller detects `$request->ajax()` to return **only the rendered `content` section** via `renderSections()['content']`.
3. **History API** — `history.pushState` keeps the URL in sync. `popstate` handles browser back/forward.
4. **Scripts in fragments** — the SPA loader re-executes `<script>` tags inside each loaded fragment (products table JS, dashboard chart JS, etc.).
5. **CSRF** — every AJAX mutation (POST/PUT/DELETE) sends the `X-CSRF-TOKEN` header.

---
 
---

## Extending with New Pages

1. Create `resources/views/pages/my-page.blade.php`:
   ```blade
   @extends('layouts.app')
   @section('title', 'My Page')
   @section('content')
     {{-- your HTML here --}}
   @endsection
   ```

2. Add a controller method that detects AJAX:
   ```php
   public function myPage(Request $request)
   {
       if ($request->ajax()) {
           return view('pages.my-page')->renderSections()['content'];
       }
       return view('pages.my-page');
   }
   ```

3. Register the route in `routes/web.php`:
   ```php
   Route::get('/my-page', [MyController::class, 'myPage'])->name('my-page');
   ```

4. Add a sidebar link in `layouts/app.blade.php`:
   ```blade
   <a class="ni" href="{{ route('my-page') }}"
      data-route="{{ route('my-page') }}"
      data-title="My Page"
      data-sub="Page subtitle">
     <span class="ni-ic">◉</span><span class="nl">My Page</span>
   </a>
   ```

That's it — the SPA JS picks it up automatically.
