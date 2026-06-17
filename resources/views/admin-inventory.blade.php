<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory - MedCampus Admin</title>
  <style>
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

    .action-menu{position:relative;display:inline-block}
    .action-menu-btn{background:transparent;border:1px solid var(--border);border-radius:6px;padding:6px 10px;cursor:pointer;font-size:16px;color:var(--text-gray);transition:.2s}
    .action-menu-btn:hover{background:var(--bg-gray)}
    
    /* CSS UNTUK MODAL DELETE CUSTOM */
    .del-overlay{position:fixed;inset:0;background:rgba(21,30,45,.55);display:flex;align-items:center;justify-content:center;z-index:2000;opacity:0;pointer-events:none;transition:opacity .25s}
    .del-overlay.active{opacity:1;pointer-events:auto}
    .del-card{background:var(--white);border-radius:12px;padding:32px;max-width:400px;width:100%;box-shadow:0 20px 40px rgba(0,0,0,.15);transform:translateY(16px);transition:transform .25s}
    .del-overlay.active .del-card{transform:translateY(0)}
  </style>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg> MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}" class="active"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; <span>Inventory</span></div>
      <div class="topbar-right">
        <div class="search-bar"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><input type="text" id="searchInput" placeholder="Search medicines…"></div>
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
      @if(session('success'))
      <div id="successAlert" style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center; gap: 12px;">
              <span style="font-size: 20px;">✅</span>
              <span style="font-size: 14px; font-weight: 600;">{{ session('success') }}</span>
          </div>
          <button onclick="document.getElementById('successAlert').style.display='none'" style="background: none; border: none; cursor: pointer; font-size: 18px; color: #065f46; opacity: 0.7;">✕</button>
      </div>
      @endif

      <div class="page-header">
        <div><h1>Medicine Stock</h1><p>Manage and track pharmaceutical inventory across all clinics.</p></div>
        <div style="display:flex;gap:12px;">
          <select id="catFilter" class="btn btn-outline" style="padding:8px 16px;font-weight:500;cursor:pointer;">
            <option value="all">All Categories</option>
            <option value="Antibiotics">Antibiotics</option>
            <option value="Analgesics">Analgesics</option>
            <option value="Antidiabetics">Antidiabetics</option>
            <option value="Vitamins">Vitamins</option>
            <option value="Antihistamines">Antihistamines</option>
            <option value="Antacids">Antacids</option>
          </select>
          <select id="statusFilter" class="btn btn-outline" style="padding:8px 16px;font-weight:500;cursor:pointer;">
            <option value="all">All Status</option>
            <option value="in_stock">In Stock</option>
            <option value="low_stock">Low Stock</option>
            <option value="out_of_stock">Out of Stock</option>
          </select>
          <a href="{{ url('/admin/medicine/add') }}" class="btn btn-primary">➕ Add Medicine</a>
        </div>
      </div>

      <div class="grid-3" style="margin-bottom:24px;">
        <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;margin-bottom:0;">
          <div style="width:40px;height:40px;background:var(--light-green);border-radius:8px;display:flex;align-items:center;justify-content:center;">💊</div>
          <div><p style="font-size:11px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:.5px;">Total SKUs</p><h2 style="font-size:28px;line-height:1.2;">{{ $totalMeds }}</h2></div>
        </div>
        <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;margin-bottom:0;">
          <div style="width:40px;height:40px;background:#fef3c7;border-radius:8px;display:flex;align-items:center;justify-content:center;">⚠️</div>
          <div><p style="font-size:11px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:.5px;">Low Stock</p><h2 style="font-size:28px;line-height:1.2;color:#d97706;">{{ $lowStock }}</h2></div>
        </div>
        <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px;margin-bottom:0;">
          <div style="width:40px;height:40px;background:#fee2e2;border-radius:8px;display:flex;align-items:center;justify-content:center;">❌</div>
          <div><p style="font-size:11px;font-weight:700;color:var(--text-gray);text-transform:uppercase;letter-spacing:.5px;">Out of Stock</p><h2 style="font-size:28px;line-height:1.2;color:#ef4444;">{{ $outOfStock }}</h2></div>
        </div>
      </div>

      <div class="table-container">
        <table>
          <thead><tr><th>Medicine Name</th><th>Category</th><th>Unit</th><th>Stock Level</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody id="medBody">
            @foreach($medicines as $med)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:12px;">
                  <div style="width:40px;height:40px;background:var(--light-green);color:var(--primary-green);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">💊</div>
                  <div>
                    <h4 style="font-size:14px;color:var(--dark-navy);">{{ $med->med_name }}</h4>
                    <p style="font-size:12px;color:var(--text-gray);">ID: {{ $med->id_med }}</p>
                  </div>
                </div>
              </td>
              <td style="color:var(--text-gray);">{{ $med->med_category }}</td>
              <td style="color:var(--text-gray);">{{ $med->med_unit }}</td>
              <td>
                <div style="font-weight:600;font-size:14px;margin-bottom:4px;">{{ $med->stock }} units</div>
              </td>
              <td>
                @if($med->status == 'in_stock')
                    <span class="badge badge-active">In Stock</span>
                @elseif($med->status == 'low_stock')
                    <span class="badge badge-warning">Low Stock</span>
                @else
                    <span class="badge badge-suspended">Out of Stock</span>
                @endif
              </td>
              <td>
                <div class="action-menu">
                  <a href="{{ url('/admin/medicine/edit/' . $med->id_med) }}" style="text-decoration:none; margin-right:8px;" title="Edit">✏️</a>
                  <a href="javascript:void(0)" onclick="openDeleteModal('{{ url('/admin/medicine/delete/' . $med->id_med) }}')" style="text-decoration:none; color:#ef4444;" title="Delete">🗑</a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        <div id="emptyState" style="text-align:center;padding:60px 24px;color:var(--text-gray);display:none;">
          <div style="font-size:40px;margin-bottom:12px;">💊</div>
          <h3 style="color:var(--dark-navy);margin-bottom:8px;">No medicines found</h3>
          <p>Try adjusting your search or filter.</p>
        </div>
        
        <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);">
          <span id="countLabel" style="font-size:13px;color:var(--text-gray);"></span>
          <a href="{{ url('/admin/medicine/add') }}" class="btn btn-primary" style="padding:8px 16px;">➕ Add Medicine</a>
        </div>
      </div>
    </main>

    <div id="customDeleteModal" class="del-overlay">
      <div class="del-card">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
          <div style="width:48px;height:48px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;color:#ef4444;flex-shrink:0;">🗑</div>
          <h2 style="font-size:20px;font-weight:700;color:var(--dark-navy);margin:0;">Delete Medicine</h2>
        </div>
        <p style="color:#475569;font-size:15px;margin-bottom:12px;line-height:1.5;">Are you sure you want to permanently delete this medicine data?</p>
        <p style="color:#ef4444;font-size:13px;margin-bottom:28px;">⚠ This action cannot be undone.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
          <button onclick="closeDeleteModal()" style="padding:10px 24px;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;border:1px solid #cbd5e1;background:#fff;color:#475569;transition:.2s;">Cancel</button>
          <a href="#" id="confirmDeleteBtn" style="background:#ef4444;color:white;padding:10px 24px;border:none;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;text-decoration:none;transition:.2s;">Delete Medicine</a>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>

  <script>
    function openDeleteModal(deleteUrl) {
        document.getElementById('confirmDeleteBtn').href = deleteUrl; 
        document.getElementById('customDeleteModal').classList.add('active');
    }
    function closeDeleteModal() {
        document.getElementById('customDeleteModal').classList.remove('active');
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('medBody');
        const emptyState = document.getElementById('emptyState');
        const tableElement = tableBody ? tableBody.parentElement : null;

        if (searchInput && tableBody) {
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = tableBody.getElementsByTagName('tr');
                let visibleCount = 0;

                for (let i = 0; i < rows.length; i++) {
                    const rowText = rows[i].textContent || rows[i].innerText;
                    
                    if (rowText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                        visibleCount++;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }

                if (emptyState && tableElement) {
                    if (visibleCount === 0) {
                        emptyState.style.display = 'block';
                        tableElement.style.display = 'none';
                    } else {
                        emptyState.style.display = 'none';
                        tableElement.style.display = 'table';
                    }
                }
            });
        }
    });
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