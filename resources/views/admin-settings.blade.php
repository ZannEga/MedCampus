<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - MedCampus</title>
  <style>
    body.dark-mode { background:#1a1f2e !important; color:#e2e8f0 !important; }
    body.dark-mode .sidebar { background:#0f1623; border-color:#2d3748; }
    body.dark-mode .main-wrapper { background:#1a1f2e; }
    body.dark-mode .topbar { background:#0f1623; border-color:#2d3748; }
    body.dark-mode .card, body.dark-mode .admin-form-container,
    body.dark-mode .settings-section, body.dark-mode .preference-card { background:#242938; border-color:#2d3748; color:#e2e8f0; }
    body.dark-mode .admin-form-input, body.dark-mode .admin-form-select { background:#1a1f2e; border-color:#4a5568; color:#e2e8f0; }
    body.dark-mode .sidebar-nav a, body.dark-mode .sidebar-footer a { color:#94a3b8; }
    body.dark-mode .sidebar-nav a:hover { background:#1a1f2e; color:#e2e8f0; }
    body.dark-mode .page-header h1, body.dark-mode .admin-form-title { color:#e2e8f0; }
    body.dark-mode .topbar .breadcrumb { color:#94a3b8; }
    
    .notif-panel { position:absolute; right:0; top:calc(100% + 8px); width:320px; background:var(--white); border:1px solid var(--border); border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200; display:none; overflow:hidden; }
    .notif-panel.open { display:block; }
    .notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .notif-header h4 { font-size:14px; font-weight:700; }
    .notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
    .notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
    .notif-item:hover { background:var(--bg-gray); }
    .notif-item:last-child { border-bottom:none; }
    .notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
    .notif-item h5 { font-size:13px; margin-bottom:3px; }
    .notif-item p  { font-size:11px; color:var(--text-gray); }
    .bell-wrapper  { position:relative; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo">
      <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
      MedCampus
    </div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer">
      <a href="{{ url('/admin/settings') }}" class="active">
        <svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
    </div>
  </aside>
  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; <span>Settings</span></div>
      <div class="topbar-right">
        
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;">🔔</div>
        <div class="admin-profile">
          <div class="admin-info">
            <h4>{{ Auth::user()->user_name }}</h4>
            <p>Super Admin</p>
          </div>
          <div class="admin-avatar">
            <img src="https://placehold.co/40x40/94a3b8/fff?text={{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}" alt="Avatar" style="width:100%;">
          </div>
          <a href="{{ url('/logout') }}" title="Keluar" style="background:none;border:1px solid #fecaca;color:#ef4444;font-size:12px;font-weight:600;padding:5px 10px;border-radius:6px;cursor:pointer;margin-left:8px;text-decoration:none;">↩</a>
        </div>
      </div>
    </header>
    <main class="content-area">
      <div class="page-header">
        <div>
          <h1>Settings</h1>
          <p>Manage your account, security, and system preferences.</p>
        </div>
      </div>

      <div class="grid-2-chart" style="grid-template-columns:2fr 1fr;">
        <div class="settings-section">
          <h2 class="admin-form-title" style="margin-bottom:32px;"><span style="color:var(--primary-green);background:var(--light-green);padding:8px;border-radius:8px;">👤</span> Profile Settings<br><span style="font-size:13px;font-weight:500;color:var(--text-gray);display:block;margin-top:4px;">Manage your personal clinical identity and credentials.</span></h2>
          <div style="display:flex;gap:32px;">
            <div style="text-align:center;">
              <div class="avatar-edit-box">
                <img src="https://placehold.co/120x120/1e293b/ffffff?text={{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}" alt="Admin" style="width:100%;height:100%;object-fit:cover;">
                <label for="avatarUpload" class="avatar-edit-btn">✏️</label>
                <input type="file" id="avatarUpload" accept="image/*" style="display:none;">
              </div>
              <span style="font-size:11px;font-weight:700;color:var(--primary-green);cursor:pointer;">CHANGE PHOTO</span>
            </div>
            <div style="flex:1;">
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div><label class="admin-form-label">Admin Name</label><input type="text" class="admin-form-input" value="{{ Auth::user()->user_name }}"></div>
                <div><label class="admin-form-label">Clinical ID</label><input type="text" class="admin-form-input" value="{{ Auth::user()->id_user }}" readonly style="color:var(--text-gray);background:var(--bg-gray);"></div>
              </div>
              <div style="margin-bottom:24px;"><label class="admin-form-label">Email Address</label><input type="email" class="admin-form-input" value="{{ Auth::user()->user_email }}"></div>
              <div style="text-align:right;"><button class="btn btn-primary">Save Profile Changes</button></div>
            </div>
          </div>
        </div>
        <div class="settings-section">
          <h2 class="admin-form-title" style="margin-bottom:24px;"><span style="color:var(--primary-green);">🛡️</span> Security</h2>
          <div class="security-item"><span>Change Password</span><span style="color:var(--text-gray);">&gt;</span></div>
          <div class="security-item"><div>Two-Factor Auth<div style="font-size:10px;font-weight:700;color:var(--primary-green);margin-top:2px;">ENABLED</div></div><span style="color:var(--text-gray);">&gt;</span></div>
        </div>
      </div>
      <div style="background:var(--bg-gray);border-radius:16px;padding:32px;border:1px solid var(--border);margin-top:24px;">
        <h2 style="font-size:20px;margin-bottom:8px;">System Preferences</h2>
        <p style="color:var(--text-gray);font-size:14px;margin-bottom:24px;">Tailor the MedCampus interface and automation workflows.</p>
        <div class="grid-3">
          <div class="preference-card">
            <div class="flex-between" style="margin-bottom:16px;">
              <div style="width:36px;height:36px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;">✉️</div>
              <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
            </div>
            <h4 style="font-size:16px;margin-bottom:8px;">Email Notifications</h4>
            <p style="font-size:13px;color:var(--text-gray);">Receive daily clinical summaries and urgent inventory alerts via email.</p>
          </div>
          <div class="preference-card">
            <div class="flex-between" style="margin-bottom:16px;">
              <div style="width:36px;height:36px;background:var(--bg-gray);color:var(--text-gray);border-radius:8px;display:flex;align-items:center;justify-content:center;">🌙</div>
              <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
            </div>
            <h4 style="font-size:16px;margin-bottom:8px;">Dark Mode</h4>
            <p style="font-size:13px;color:var(--text-gray);">Reduce eye strain during night shifts with our dark theme.</p>
          </div>
          <div class="preference-card">
            <div class="flex-between" style="margin-bottom:16px;">
              <div style="width:36px;height:36px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;">☁️</div>
              <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
            </div>
            <h4 style="font-size:16px;margin-bottom:8px;">Automatic Backups</h4>
            <p style="font-size:13px;color:var(--text-gray);">System-wide data encryption and cloud backup every 6 hours.</p>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    // ── Dark Mode toggle ──────────────────────────────────────────────────────
    const darkToggle = document.querySelector('.preference-card:nth-child(2) .toggle-switch input');
    if (darkToggle) {
      // Restore dark mode state
      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      darkToggle.checked = isDark;
      if (isDark) document.body.classList.add('dark-mode');

      darkToggle.addEventListener('change', () => {
        const on = darkToggle.checked;
        document.body.classList.toggle('dark-mode', on);
        localStorage.setItem('mc_dark_mode', on ? '1' : '0');
      });
    }
  </script>

  <script>
    (function() {
      const bellWrap = document.querySelector('.bell-wrapper');
      if (!bellWrap) return;

      const panel = document.createElement('div');
      panel.className = 'notif-panel';
      panel.innerHTML = '<div class="notif-header"><h4>🔔 Notifications</h4><span id="clearNotifs">Mark all read</span></div><div id="notifList"></div>';
      bellWrap.style.position = 'relative';
      bellWrap.appendChild(panel);

      function renderNotifs() {
        const list = document.getElementById('notifList');
        if (!list) return;
        list.innerHTML = '';
        const notifs = [{ color:'#94a3b8', title:'✅ All Clear', body: 'No new notifications right now.' }];
        notifs.forEach(n => {
          const div = document.createElement('div');
          div.className = 'notif-item';
          div.innerHTML = `<div class="notif-dot" style="background:${n.color};"></div><div><h5>${n.title}</h5><p>${n.body}</p></div>`;
          list.appendChild(div);
        });
      }

      bellWrap.addEventListener('click', e => {
        e.stopPropagation();
        renderNotifs();
        panel.classList.toggle('open');
      });
      document.addEventListener('click', () => panel.classList.remove('open'));
    })();
  </script>
</body>
</html>