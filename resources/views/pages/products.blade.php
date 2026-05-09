@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')
@section('page-sub', 'Manage products — create, read, update, delete')

@section('content')
    <div class="card" style="padding:14px;">

        {{-- Toolbar --}}
        <div
            style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;flex-wrap:wrap;gap:6px;">
            <div style="font-family:'Syne',sans-serif;font-size:11px;font-weight:700;">Product List</div>
            <button class="btn p" onclick="openM()">＋ Add Product</button>
        </div>

        {{-- Filters --}}
        <div class="dtc">
            <input type="text" id="ds" class="inp" placeholder="Search products…" style="width:160px;"
                   oninput="cp=1;rT()">
            <select id="dc" class="inp" onchange="cp=1;rT()">
                <option value="">All Categories</option>
                <option>Electronics</option>
                <option>Clothing</option>
                <option>Software</option>
                <option>Hardware</option>
                <option>Books</option>
            </select>
            <select id="dst" class="inp" onchange="cp=1;rT()">
                <option value="">All Statuses</option>
                <option>Active</option>
                <option>Draft</option>
                <option>Archived</option>
            </select>
            <select id="dpp" class="inp" onchange="cp=1;rT()">
                <option value="5">5 / page</option>
                <option value="10" selected>10 / page</option>
                <option value="25">25 / page</option>
            </select>
            <button class="btn" onclick="clrF()">✕ Clear</button>
            <span id="bulk-info" style="font-size:9px;color:var(--tm);">0 selected</span>
            <button class="btn d" id="bdel" onclick="bulkDel()" style="display:none;font-size:9px;padding:3px 8px;">
                Delete selected
            </button>
        </div>
        <span id="dtcount" style="font-size:9px;color:var(--tm);display:block;margin-bottom:6px;"></span>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table id="dtt" style="min-width:640px;">
                <thead>
                <tr>
                    <th style="width:28px;"><input type="checkbox" id="ca" onchange="togAll(this)"
                                                   style="accent-color:var(--ac);width:11px;height:11px;cursor:pointer;">
                    </th>
                    <th class="st" onclick="srtB('id')"># <span class="sic asc" id="si-id"></span></th>
                    <th class="st" onclick="srtB('name')">Product <span class="sic" id="si-name"></span></th>
                    <th class="st" onclick="srtB('category')">Category <span class="sic" id="si-category"></span></th>
                    <th class="st" onclick="srtB('price')">Price <span class="sic" id="si-price"></span></th>
                    <th class="st" onclick="srtB('stock')">Stock <span class="sic" id="si-stock"></span></th>
                    <th class="st" onclick="srtB('status')">Status <span class="sic" id="si-status"></span></th>
                    <th class="st" onclick="srtB('date')">Date <span class="sic" id="si-date"></span></th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="dtb"></tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="display:flex;align-items:center;justify-content:flex-end;margin-top:8px;gap:3px;" id="pgn"></div>
    </div>

    {{-- ════ MODAL ════ --}}
    <div class="mbg" id="product-modal">
        <div class="modal">
            <div class="mtitle">
                <span id="mtxt">Add Product</span>
                <button onclick="closeM()"
                        style="background:none;border:none;cursor:pointer;color:var(--tm);font-size:16px;line-height:1;padding:0;">
                    ×
                </button>
            </div>
            <div class="frow">
                <div class="fg"><label>Product Name *</label><input type="text" class="inp" id="fn"
                                                                    placeholder="e.g. MacBook Pro 14"></div>
                <div class="fg"><label>SKU</label><input type="text" class="inp" id="fsk" placeholder="e.g. MBP-14">
                </div>
            </div>
            <div class="frow">
                <div class="fg"><label>Category *</label>
                    <select class="inp" id="fct">
                        <option value="">Select…</option>
                        <option>Electronics</option>
                        <option>Clothing</option>
                        <option>Software</option>
                        <option>Hardware</option>
                        <option>Books</option>
                    </select>
                </div>
                <div class="fg"><label>Status</label>
                    <select class="inp" id="fst">
                        <option>Active</option>
                        <option>Draft</option>
                        <option>Archived</option>
                    </select>
                </div>
            </div>
            <div class="frow">
                <div class="fg"><label>Price ($) *</label><input type="number" class="inp" id="fp" placeholder="0.00"
                                                                 min="0" step="0.01"></div>
                <div class="fg"><label>Stock Qty</label><input type="number" class="inp" id="fstk" placeholder="0"
                                                               min="0"></div>
            </div>
            <div class="fg" style="margin-bottom:12px;">
                <label>Description</label>
                <textarea class="inp" id="fd" rows="2" placeholder="Short description…"
                          style="resize:vertical;width:100%;"></textarea>
            </div>
            <div id="ferr" style="color:var(--ac3);font-size:9px;margin-bottom:7px;display:none;"></div>
            <div style="display:flex;gap:7px;justify-content:flex-end;">
                <button class="btn" onclick="closeM()">Cancel</button>
                <button class="btn p" onclick="saveR()" id="sbtn">Save Product</button>
            </div>
        </div>
    </div>

    <script>
        // ─── CRUD DATA (in production, seed from controller via @json($products)) ───
        let nid = 13, eid = null, sc = 'id', sd = 'asc', cp = 1, sel = new Set();
        let data = @json($products);

        function gF() {
            const q = (document.getElementById('ds')?.value || '').toLowerCase();
            const cat = document.getElementById('dc')?.value || '';
            const st = document.getElementById('dst')?.value || '';
            return data.filter(r => {
                const mq = !q || r.name.toLowerCase().includes(q) || r.category.toLowerCase().includes(q) || r.sku.toLowerCase().includes(q);
                return mq && (!cat || r.category === cat) && (!st || r.status === st);
            });
        }

        function gS(arr) {
            return [...arr].sort((a, b) => {
                let va = a[sc], vb = b[sc];
                if (['price', 'stock', 'id'].includes(sc)) {
                    va = +va;
                    vb = +vb;
                }
                if (va < vb) return sd === 'asc' ? -1 : 1;
                if (va > vb) return sd === 'asc' ? 1 : -1;
                return 0;
            });
        }

        function srtB(col) {
            if (sc === col) {
                sd = sd === 'asc' ? 'desc' : 'asc';
            } else {
                sc = col;
                sd = 'asc';
            }
            ['id', 'name', 'category', 'price', 'stock', 'status', 'date'].forEach(c => {
                const el = document.getElementById('si-' + c);
                if (el) el.className = 'sic' + (c === sc ? ' ' + sd : '');
            });
            rT();
        }

        const stC = {Active: '#4ade80', Draft: '#fbbf24', Archived: '#f87171'};
        const stB = {Active: 'rgba(74,222,128,.1)', Draft: 'rgba(251,191,36,.1)', Archived: 'rgba(248,113,113,.1)'};

        function rT() {
            const per = +(document.getElementById('dpp')?.value || 10);
            const fil = gS(gF());
            const tot = fil.length;
            const pgs = Math.max(1, Math.ceil(tot / per));
            if (cp > pgs) cp = 1;
            const sl = fil.slice((cp - 1) * per, cp * per);
            document.getElementById('dtcount').textContent = `Showing ${sl.length} of ${tot} record${tot !== 1 ? 's' : ''}`;

            document.getElementById('dtb').innerHTML = sl.map(r => `
    <tr onmouseenter="this.style.background='var(--gs)'" onmouseleave="this.style.background='transparent'" style="transition:background .1s;">
      <td><input type="checkbox" class="rck" data-id="${r.id}" ${sel.has(r.id) ? 'checked' : ''} onchange="togRow(this,${r.id})" style="accent-color:var(--ac);width:11px;height:11px;cursor:pointer;"></td>
      <td style="color:var(--tm);font-size:9px;">${r.id}</td>
      <td><div style="font-weight:500;font-size:10.5px;">${r.name}</div><div style="font-size:8.5px;color:var(--tm);">${r.sku}</div></td>
      <td><span style="background:rgba(167,139,250,.09);color:#a78bfa;padding:1px 6px;border-radius:4px;font-size:8.5px;">${r.category}</span></td>
      <td style="font-weight:600;font-size:10.5px;">$${r.price.toLocaleString()}</td>
      <td style="font-size:10.5px;${r.stock === 0 ? 'color:#f87171' : ''}">${r.stock === 0 ? 'Out' : r.stock}</td>
      <td><span style="background:${stB[r.status]};color:${stC[r.status]};padding:1px 6px;border-radius:4px;font-size:8.5px;">${r.status}</span></td>
      <td style="color:var(--tm);font-size:9px;">${r.date}</td>
      <td><div style="display:flex;gap:3px;">
        <button class="btn" onclick="openM(${r.id})" style="padding:2px 7px;font-size:9px;">Edit</button>
        <button class="btn d" onclick="delR(${r.id})" style="padding:2px 7px;font-size:9px;">Del</button>
      </div></td>
    </tr>`).join('');

            // Pagination
            const pEl = document.getElementById('pgn');
            let h = `<button class="pb" onclick="goP(${cp - 1})" ${cp <= 1 ? 'disabled' : ''}>‹</button>`;
            const rng = [];
            for (let i = 1; i <= pgs; i++) {
                if (i === 1 || i === pgs || Math.abs(i - cp) <= 1) rng.push(i);
                else if (rng[rng.length - 1] !== '…') rng.push('…');
            }
            rng.forEach(p => {
                if (p === '…') h += `<span style="font-size:9px;color:var(--tm);padding:0 2px;">…</span>`;
                else h += `<button class="pb ${p === cp ? 'act' : ''}" onclick="goP(${p})">${p}</button>`;
            });
            h += `<button class="pb" onclick="goP(${cp + 1})" ${cp >= pgs ? 'disabled' : ''}>›</button>`;
            pEl.innerHTML = h;
            updBulk();
        }

        function goP(p) {
            const per = +(document.getElementById('dpp')?.value || 10);
            const pgs = Math.ceil(gF().length / per);
            if (p < 1 || p > pgs) return;
            cp = p;
            rT();
        }

        function togRow(chk, id) {
            chk.checked ? sel.add(id) : sel.delete(id);
            updBulk();
        }

        function togAll(chk) {
            document.querySelectorAll('.rck').forEach(c => {
                const id = +c.dataset.id;
                c.checked = chk.checked;
                chk.checked ? sel.add(id) : sel.delete(id);
            });
            updBulk();
        }

        function updBulk() {
            const n = sel.size;
            document.getElementById('bulk-info').textContent = `${n} selected`;
            document.getElementById('bdel').style.display = n > 0 ? '' : 'none';
        }

        function bulkDel() {
            if (!confirm(`Delete ${sel.size} record(s)?`)) return;
            data = data.filter(r => !sel.has(r.id));
            sel.clear();
            rT();
            // In production: send AJAX DELETE to /products/bulk-delete with sel array
        }

        function clrF() {
            document.getElementById('ds').value = '';
            document.getElementById('dc').value = '';
            document.getElementById('dst').value = '';
            cp = 1;
            rT();
        }

        // MODAL
        function openM(id = null) {
            eid = id;
            const r = id ? data.find(x => x.id === id) : null;
            document.getElementById('mtxt').textContent = id ? 'Edit Product' : 'Add Product';
            document.getElementById('sbtn').textContent = id ? 'Update' : 'Save Product';
            document.getElementById('fn').value = r?.name || '';
            document.getElementById('fsk').value = r?.sku || '';
            document.getElementById('fct').value = r?.category || '';
            document.getElementById('fst').value = r?.status || 'Active';
            document.getElementById('fp').value = r?.price || '';
            document.getElementById('fstk').value = r?.stock || '';
            document.getElementById('fd').value = r?.desc || '';
            document.getElementById('ferr').style.display = 'none';
            document.getElementById('product-modal').classList.add('open');
        }

        function closeM() {
            document.getElementById('product-modal').classList.remove('open');
        }

        function saveR() {
            const name = document.getElementById('fn').value.trim();
            const cat = document.getElementById('fct').value;
            const price = parseFloat(document.getElementById('fp').value);
            const err = document.getElementById('ferr');
            if (!name || !cat || isNaN(price)) {
                err.textContent = 'Name, category, and price are required.';
                err.style.display = 'block';
                return;
            }
            const obj = {
                id: eid || nid++,
                name, sku: document.getElementById('fsk').value || '—',
                category: cat,
                status: document.getElementById('fst').value,
                price: Math.round(price * 100) / 100,
                stock: +document.getElementById('fstk').value || 0,
                date: new Date().toISOString().slice(0, 10),
                desc: document.getElementById('fd').value || ''
            };
            if (eid) {
                data = data.map(r => r.id === eid ? obj : r);
            } else {
                data.unshift(obj);
                cp = 1;
            }
            closeM();
            rT();

            // ── AJAX PERSIST to Laravel ──
            fetch(eid ? `/products/${eid}` : '/products', {
                method: eid ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(obj)
            }).then(r => r.json()).then(res => {
                if (res.id && !eid) {
                    nid = res.id + 1;
                }
            }).catch(console.error);
        }

        function delR(id) {
            if (!confirm('Delete this product?')) return;
            data = data.filter(r => r.id !== id);
            sel.delete(id);
            rT();
            // AJAX DELETE
            fetch(`/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).catch(console.error);
        }

        // init
        ['id', 'name', 'category', 'price', 'stock', 'status', 'date'].forEach(c => {
            const el = document.getElementById('si-' + c);
            if (el) el.className = 'sic' + (c === 'id' ? ' asc' : '');
        });
        document.getElementById('product-modal').addEventListener('click', function (e) {
            if (e.target === this) closeM();
        });
        rT();
    </script>
@endsection
