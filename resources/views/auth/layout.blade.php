<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Nexus') — Auth</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
/* ── RESET & BASE ── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --bg-deep:#04080f;
  --orb1:#0ea5e9;
  --orb2:#8b5cf6;
  --orb3:#ec4899;
  --glass-bg:rgba(255,255,255,.055);
  --glass-border:rgba(255,255,255,.10);
  --glass-shadow:0 32px 64px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.06);
  --input-bg:rgba(255,255,255,.06);
  --input-border:rgba(255,255,255,.12);
  --input-focus:#0ea5e9;
  --text:#f0f6ff;
  --muted:rgba(200,218,255,.5);
  --accent:#0ea5e9;
  --accent2:#8b5cf6;
  --danger:#f43f5e;
  --success:#10b981;
  --radius:18px;
  --radius-sm:10px;
  --transition:.22s cubic-bezier(.4,0,.2,1);
}

html,body{height:100%;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:var(--bg-deep);overflow:hidden;}

/* ── ANIMATED BACKGROUND ── */
.bg-scene{position:fixed;inset:0;z-index:0;overflow:hidden;}
.bg-scene::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 80% 70% at 15% 20%,rgba(14,165,233,.18) 0%,transparent 55%),
             radial-gradient(ellipse 60% 60% at 85% 75%,rgba(139,92,246,.20) 0%,transparent 55%),
             radial-gradient(ellipse 50% 50% at 50% 50%,rgba(236,72,153,.10) 0%,transparent 65%);
  animation:bg-shift 12s ease-in-out infinite alternate;
}
@keyframes bg-shift{
  0%  {background-position:0% 0%;}
  50% {filter:hue-rotate(15deg);}
  100%{background-position:100% 100%;filter:hue-rotate(-10deg);}
}

/* floating orbs */
.orb{position:absolute;border-radius:50%;filter:blur(80px);opacity:.55;animation:orb-float linear infinite;}
.orb-1{width:520px;height:520px;top:-120px;left:-160px;background:radial-gradient(circle,var(--orb1),transparent 70%);animation-duration:18s;}
.orb-2{width:600px;height:600px;bottom:-200px;right:-180px;background:radial-gradient(circle,var(--orb2),transparent 70%);animation-duration:22s;animation-delay:-8s;}
.orb-3{width:350px;height:350px;top:40%;left:50%;background:radial-gradient(circle,var(--orb3),transparent 70%);animation-duration:15s;animation-delay:-4s;}
@keyframes orb-float{
  0%  {transform:translate(0,0) scale(1);}
  33% {transform:translate(30px,-25px) scale(1.05);}
  66% {transform:translate(-20px,20px) scale(.95);}
  100%{transform:translate(0,0) scale(1);}
}

/* grid lines */
.bg-grid{
  position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
  background-size:60px 60px;
}

/* ── CENTERED AUTH SHELL ── */
.auth-shell{
  position:relative;z-index:10;
  display:flex;align-items:center;justify-content:center;
  min-height:100vh;padding:24px;
}

/* ── GLASS CARD ── */
.glass-card{
  width:100%;max-width:420px;
  background:var(--glass-bg);
  backdrop-filter:blur(28px) saturate(180%);
  -webkit-backdrop-filter:blur(28px) saturate(180%);
  border:1px solid var(--glass-border);
  border-radius:var(--radius);
  box-shadow:var(--glass-shadow);
  padding:40px 36px 36px;
  animation:card-in .6s cubic-bezier(.16,1,.3,1) both;
}
@keyframes card-in{
  from{opacity:0;transform:translateY(28px) scale(.97);}
  to  {opacity:1;transform:translateY(0) scale(1);}
}

/* ── LOGO MARK ── */
.logo-mark{
  display:flex;align-items:center;gap:10px;margin-bottom:28px;
}
.logo-icon{
  width:38px;height:38px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,var(--orb1),var(--orb2));
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 0 1px rgba(255,255,255,.15),0 8px 20px rgba(14,165,233,.35);
}
.logo-text{font-family:'Syne',sans-serif;font-weight:800;font-size:17px;letter-spacing:-.3px;}
.logo-sub{font-size:11px;color:var(--muted);margin-top:1px;}

/* ── HEADINGS ── */
.auth-heading{
  font-family:'Syne',sans-serif;font-weight:700;font-size:22px;
  letter-spacing:-.4px;margin-bottom:6px;
  animation:fade-up .5s .1s both;
}
.auth-sub{
  font-size:12.5px;color:var(--muted);margin-bottom:28px;
  animation:fade-up .5s .15s both;
}
@keyframes fade-up{from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:none;}}

/* ── FORM ── */
.form-group{margin-bottom:16px;animation:fade-up .5s both;}
.form-group:nth-child(1){animation-delay:.18s;}
.form-group:nth-child(2){animation-delay:.22s;}
.form-group:nth-child(3){animation-delay:.26s;}
.form-group:nth-child(4){animation-delay:.30s;}
.form-group:nth-child(5){animation-delay:.34s;}

.form-label{
  display:block;font-size:11px;font-weight:500;letter-spacing:.05em;
  text-transform:uppercase;color:var(--muted);margin-bottom:7px;
}
.form-input-wrap{position:relative;}
.form-icon{
  position:absolute;left:13px;top:50%;transform:translateY(-50%);
  color:var(--muted);pointer-events:none;display:flex;
  transition:color var(--transition);
}
.form-input{
  width:100%;padding:11px 13px 11px 38px;
  background:var(--input-bg);
  border:1px solid var(--input-border);
  border-radius:var(--radius-sm);
  color:var(--text);font-family:'DM Sans',sans-serif;font-size:13.5px;
  outline:none;transition:border-color var(--transition),background var(--transition),box-shadow var(--transition);
  -webkit-appearance:none;
}
.form-input::placeholder{color:rgba(200,218,255,.3);}
.form-input:focus{
  border-color:var(--input-focus);
  background:rgba(14,165,233,.07);
  box-shadow:0 0 0 3px rgba(14,165,233,.15);
}
.form-input:focus + .form-icon-after,
.form-input-wrap:focus-within .form-icon{color:var(--accent);}

/* password toggle */
.pwd-toggle{
  position:absolute;right:12px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;color:var(--muted);
  display:flex;padding:4px;border-radius:6px;transition:color var(--transition);
}
.pwd-toggle:hover{color:var(--text);}

/* ── CHECKBOX / REMEMBER ── */
.form-check{display:flex;align-items:center;gap:8px;}
.form-check input[type="checkbox"]{
  width:15px;height:15px;border-radius:4px;border:1px solid var(--input-border);
  background:var(--input-bg);accent-color:var(--accent);cursor:pointer;
  flex-shrink:0;
}
.form-check label{font-size:12px;color:var(--muted);cursor:pointer;user-select:none;}

/* ── FORGOT LINK ── */
.forgot-link{font-size:12px;color:var(--accent);text-decoration:none;opacity:.85;transition:opacity var(--transition);}
.forgot-link:hover{opacity:1;}

/* ── PRIMARY BUTTON ── */
.btn-primary{
  width:100%;padding:12px;margin-top:20px;
  background:linear-gradient(135deg,var(--orb1) 0%,var(--orb2) 100%);
  border:none;border-radius:var(--radius-sm);
  color:#fff;font-family:'Syne',sans-serif;font-weight:700;font-size:13.5px;
  letter-spacing:.02em;cursor:pointer;
  box-shadow:0 4px 20px rgba(14,165,233,.35),0 0 0 1px rgba(255,255,255,.1) inset;
  transition:transform var(--transition),box-shadow var(--transition),filter var(--transition);
  animation:fade-up .5s .38s both;
  position:relative;overflow:hidden;
}
.btn-primary::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,rgba(255,255,255,.12) 0%,transparent 60%);
  pointer-events:none;
}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 28px rgba(14,165,233,.45),0 0 0 1px rgba(255,255,255,.15) inset;filter:brightness(1.05);}
.btn-primary:active{transform:translateY(0);filter:brightness(.97);}
.btn-primary:disabled{opacity:.55;cursor:not-allowed;transform:none;}

/* loading spinner on button */
.btn-primary.loading{pointer-events:none;}
.btn-primary.loading .btn-text{opacity:0;}
.btn-primary.loading::before{
  content:'';position:absolute;width:18px;height:18px;
  border:2px solid rgba(255,255,255,.3);border-top-color:#fff;
  border-radius:50%;animation:spin .7s linear infinite;
  top:50%;left:50%;margin:-9px 0 0 -9px;
}
@keyframes spin{to{transform:rotate(360deg);}}

/* ── DIVIDER ── */
.divider{display:flex;align-items:center;gap:10px;margin:20px 0;animation:fade-up .5s .4s both;}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--glass-border);}
.divider span{font-size:11px;color:var(--muted);white-space:nowrap;}

/* ── SOCIAL BUTTONS ── */
.social-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;animation:fade-up .5s .44s both;}
.btn-social{
  display:flex;align-items:center;justify-content:center;gap:7px;
  padding:10px;border-radius:var(--radius-sm);
  background:var(--input-bg);border:1px solid var(--input-border);
  color:var(--text);font-family:'DM Sans',sans-serif;font-size:12.5px;font-weight:500;
  cursor:pointer;text-decoration:none;
  transition:background var(--transition),border-color var(--transition),transform var(--transition);
}
.btn-social:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);transform:translateY(-1px);}
.btn-social svg{flex-shrink:0;}

/* ── SWITCH LINK ── */
.auth-switch{
  text-align:center;margin-top:22px;font-size:12.5px;color:var(--muted);
  animation:fade-up .5s .48s both;
}
.auth-switch a{color:var(--accent);text-decoration:none;font-weight:500;transition:color var(--transition);}
.auth-switch a:hover{color:#38bdf8;}

/* ── ERROR / SUCCESS ALERTS ── */
.alert{
  padding:11px 14px;border-radius:var(--radius-sm);
  font-size:12.5px;margin-bottom:16px;display:flex;align-items:flex-start;gap:9px;
  animation:fade-up .3s both;
}
.alert-error{background:rgba(244,63,94,.12);border:1px solid rgba(244,63,94,.25);color:#fda4af;}
.alert-success{background:rgba(16,185,129,.10);border:1px solid rgba(16,185,129,.25);color:#6ee7b7;}
.alert svg{flex-shrink:0;margin-top:1px;}

/* field error */
.field-error{font-size:11px;color:#fda4af;margin-top:5px;display:flex;align-items:center;gap:4px;}

/* ── OTP INPUT ── */
.otp-row{display:flex;gap:10px;justify-content:center;margin-bottom:8px;}
.otp-input{
  width:52px;height:56px;text-align:center;font-family:'Syne',sans-serif;
  font-size:22px;font-weight:700;
  background:var(--input-bg);border:1px solid var(--input-border);
  border-radius:var(--radius-sm);color:var(--text);outline:none;
  transition:border-color var(--transition),box-shadow var(--transition);
  -webkit-appearance:none;
}
.otp-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(14,165,233,.18);}

/* ── PROGRESS STEPS ── */
.step-bar{display:flex;align-items:center;gap:0;margin-bottom:24px;}
.step-item{display:flex;flex-direction:column;align-items:center;flex:1;}
.step-dot{
  width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;
  font-size:11px;font-weight:700;font-family:'Syne',sans-serif;
  border:1px solid var(--input-border);background:var(--input-bg);color:var(--muted);
  transition:all var(--transition);
}
.step-dot.active{background:var(--accent);border-color:var(--accent);color:#fff;box-shadow:0 0 0 4px rgba(14,165,233,.2);}
.step-dot.done{background:var(--success);border-color:var(--success);color:#fff;}
.step-line{height:1px;flex:1;background:var(--glass-border);}
.step-label{font-size:9.5px;color:var(--muted);margin-top:4px;letter-spacing:.05em;text-transform:uppercase;}

/* ── PASSWORD STRENGTH ── */
.pwd-strength-bar{display:flex;gap:4px;margin-top:8px;}
.pwd-segment{height:3px;flex:1;border-radius:99px;background:rgba(255,255,255,.1);transition:background .3s;}
.pwd-segment.weak{background:var(--danger);}
.pwd-segment.fair{background:#f59e0b;}
.pwd-segment.good{background:#3b82f6;}
.pwd-segment.strong{background:var(--success);}
.pwd-hint{font-size:10.5px;color:var(--muted);margin-top:5px;}

/* ── SCROLLBAR ── */
::-webkit-scrollbar{width:4px;}
::-webkit-scrollbar-thumb{background:var(--glass-border);border-radius:99px;}
</style>
</head>
<body>
<div class="bg-scene">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
  <div class="bg-grid"></div>
</div>

<div class="auth-shell">
  <div class="glass-card">
    <!-- Logo -->
    <div class="logo-mark">
      <div class="logo-icon">
        <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
          <path d="M3 10L10 3L17 10L10 17L3 10Z" fill="white" fill-opacity=".9"/>
          <circle cx="10" cy="10" r="3" fill="white"/>
        </svg>
      </div>
      <div>
        <div class="logo-text">NEXUS</div>
        <div class="logo-sub">Admin Platform</div>
      </div>
    </div>

    @yield('auth-content')
  </div>
</div>

<script>
function togglePwd(btn) {
  const inp = btn.closest('.form-input-wrap').querySelector('.form-input');
  const isText = inp.type === 'text';
  inp.type = isText ? 'password' : 'text';
  btn.innerHTML = isText
    ? `<svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M1 10s3.5-7 9-7 9 7 9 7-3.5 7-9 7S1 10 1 10Z" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.4"/></svg>`
    : `<svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M2 2l16 16M8.5 8.58A3 3 0 0010 13a3 3 0 003-3M6.35 6.4C3.93 7.88 2 10 2 10s3.5 7 8 7c1.85 0 3.56-.65 4.97-1.7M10.73 4.07C10.49 4.03 10.24 4 10 4c-4.5 0-8 6-8 6s.66 1.12 1.85 2.35" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>`;
}

function checkStrength(val) {
  const segs = document.querySelectorAll('.pwd-segment');
  const hint = document.querySelector('.pwd-hint');
  if (!segs.length) return;
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const labels = ['','Weak','Fair','Good','Strong'];
  const classes = ['','weak','fair','good','strong'];
  segs.forEach((s,i) => {
    s.className = 'pwd-segment' + (i < score ? ' ' + classes[score] : '');
  });
  if (hint) hint.textContent = val ? labels[score] || '' : '';
}

// OTP auto-advance
document.querySelectorAll('.otp-input').forEach((inp, i, all) => {
  inp.addEventListener('input', () => {
    inp.value = inp.value.slice(-1);
    if (inp.value && all[i+1]) all[i+1].focus();
  });
  inp.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !inp.value && all[i-1]) all[i-1].focus();
  });
  inp.addEventListener('paste', e => {
    e.preventDefault();
    const digits = (e.clipboardData.getData('text').match(/\d/g) || []);
    digits.slice(0,6).forEach((d,j) => { if (all[i+j]) all[i+j].value = d; });
    if (all[Math.min(i+digits.length, 5)]) all[Math.min(i+digits.length, 5)].focus();
  });
});

// Button loading state
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', () => {
    const btn = form.querySelector('.btn-primary');
    if (btn) { btn.classList.add('loading'); btn.disabled = true; }
  });
});
</script>
@stack('scripts')
</body>
</html>
