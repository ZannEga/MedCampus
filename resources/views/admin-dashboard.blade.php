<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - MedCampus</title>
  <style>
    /* CSS Notifikasi dsb */
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
    <div class="sidebar-logo"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg> MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}" class="active"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; <span>Dashboard</span></div>
      <div class="topbar-right">
        <div class="search-bar"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><input type="text" placeholder="Search…"></div>
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
        <div><h1>Dashboard Overview</h1><p>Real-time performance metrics and system health monitoring.</p></div>
        <span id="dash-date" style="font-size:13px;color:var(--text-gray);font-weight:500;"></span>
      </div>

      <div class="grid-3" style="margin-bottom:32px;">
        <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;">
          <div class="flex-between" style="margin-bottom:24px;">
            <div style="width:40px;height:40px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;">👤</div>
            <span class="badge badge-active">{{ $activeUsers }} Active</span>
          </div>
          <p style="font-size:12px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:1px;">Registered Users</p>
          <h2 style="font-size:36px;line-height:1;margin-top:8px;">{{ $totalUsers }}</h2>
        </div>

        <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;">
          <div class="flex-between" style="margin-bottom:24px;">
            <div style="width:40px;height:40px;background:#fff7ed;color:#ea580c;border-radius:8px;display:flex;align-items:center;justify-content:center;">💊</div>
            @if($lowStockMeds > 0)
                <span class="badge badge-warning">{{ $lowStockMeds }} Low/Out</span>
            @else
                <span class="badge badge-active">All Good</span>
            @endif
          </div>
          <p style="font-size:12px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:1px;">Medicine Stock</p>
          <h2 style="font-size:36px;line-height:1;margin-top:8px;">{{ $totalMeds }} <span style="font-size:16px;color:var(--text-gray);">SKU</span></h2>
        </div>

        <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;">
          <div class="flex-between" style="margin-bottom:24px;">
            <div style="width:40px;height:40px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;">📅</div>
            <span class="badge badge-active">Live System</span>
          </div>
          <p style="font-size:12px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:1px;">Total Schedules</p>
          <h2 style="font-size:36px;line-height:1;margin-top:8px;">{{ $totalScheds }}</h2>
        </div>
      </div>

      <div class="grid-2-chart">
        <div>
          <div class="flex-between" style="margin-bottom:16px;">
            <h3 style="font-size:18px;">Recent Registrations</h3>
            <a href="{{ url('/admin/users') }}" style="font-size:12px;font-weight:700;color:var(--primary-green);text-transform:uppercase;">View All</a>
          </div>
          
          <div id="activityFeed">
            @foreach($recentUsers as $ru)
            <div class="card" style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
              <div style="display:flex;align-items:center;gap:16px;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--primary-green);flex-shrink:0;"></div>
                <div>
                  <h4 style="font-size:14px;color:var(--dark-navy);">User: {{ $ru->user_name }}</h4>
                  <p style="font-size:12px;color:var(--text-gray);">{{ $ru->user_email }}</p>
                </div>
              </div>
              <span style="font-size:12px;color:var(--text-gray);white-space:nowrap;margin-left:16px;">{{ \Carbon\Carbon::parse($ru->created_at)->diffForHumans() }}</span>
            </div>
            @endforeach
          </div>
        </div>

        <div>
          <h3 style="font-size:18px;margin-bottom:16px;">Schedule Distribution</h3>
          <div class="card" style="display:flex;flex-direction:column;align-items:center;padding:40px 24px;">
            <div id="donut" style="width:180px;height:180px;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:32px;border:20px solid var(--primary-green);">
              <h2 id="donut-total" style="font-size:32px;line-height:1;">{{ $totalScheds }}</h2>
              <p style="font-size:10px;font-weight:700;color:var(--text-gray);text-transform:uppercase;">Total</p>
            </div>
            <div id="donut-legend" style="width:100%;"></div>
          </div>
        </div>
      </div>

      <div class="grid-3" style="margin-top:8px;">
        <a href="{{ url('/admin/users') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;padding:20px;transition:.2s;" onmouseover="this.style.borderColor='var(--primary-green)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="width:40px;height:40px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">👥</div>
          <div><h4 style="font-size:14px;">Manage Users</h4><p style="font-size:12px;color:var(--text-gray);">Add, edit or suspend accounts</p></div>
        </a>
        <a href="{{ url('/admin/inventory') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;padding:20px;transition:.2s;" onmouseover="this.style.borderColor='var(--primary-green)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="width:40px;height:40px;background:#fff7ed;color:#ea580c;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">💊</div>
          <div><h4 style="font-size:14px;">Medicine Inventory</h4><p style="font-size:12px;color:var(--text-gray);">Track and update stock levels</p></div>
        </a>
        <a href="{{ url('/admin/schedules') }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:16px;padding:20px;transition:.2s;" onmouseover="this.style.borderColor='var(--primary-green)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="width:40px;height:40px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">📅</div>
          <div><h4 style="font-size:14px;">Clinical Schedules</h4><p style="font-size:12px;color:var(--text-gray);">Manage doctor rosters and shifts</p></div>
        </a>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    // Atur Tanggal Hari Ini
    document.getElementById('dash-date').textContent = new Date().toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // Render Data Grafik Donat dari Database
    const chartData = @json($deptDistribution);
    const totalScheds = {{ $totalScheds }};
    const legend = document.getElementById('donut-legend');
    const DEPT_COLORS = ['var(--primary-green)','#84cc16','#bef264','#f97316','#a855f7'];

    if(chartData.length > 0 && totalScheds > 0) {
        chartData.forEach((item, i) => {
            const deptName = item.user_dept || 'Unknown';
            const pct = Math.round((item.count / totalScheds) * 100);
            const color = DEPT_COLORS[i % DEPT_COLORS.length];
            
            const div = document.createElement('div');
            div.className = 'flex-between';
            div.style.cssText = 'margin-bottom:16px;font-size:13px;';
            div.innerHTML = `
              <div style="display:flex;align-items:center;gap:8px;">
                <div style="width:8px;height:8px;border-radius:50%;background:${color};"></div>
                <b>${deptName}</b>
              </div>
              <b>${pct}%</b>`;
            legend.appendChild(div);
        });

        // Warnai border donat sesuai departemen dominan
        if (chartData.length >= 3) {
            document.getElementById('donut').style.borderColor        = DEPT_COLORS[0];
            document.getElementById('donut').style.borderRightColor   = DEPT_COLORS[1];
            document.getElementById('donut').style.borderBottomColor  = DEPT_COLORS[2];
        }
    } else {
        legend.innerHTML = '<p style="text-align:center;color:var(--text-gray);font-size:13px;">No schedule data available.</p>';
        document.getElementById('donut').style.borderColor = 'var(--border)';
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