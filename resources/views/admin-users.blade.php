<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users - MedCampus Admin</title>
  <style>
.notif-panel {
  position:absolute; right:0; top:calc(100% + 8px); width:320px;
  background:var(--white); border:1px solid var(--border); border-radius:12px;
  box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200;
  display:none; overflow:hidden;
}
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
  <style>
    /* Delete confirmation modal */
    .delete-modal-overlay {
      position: fixed; inset: 0;
      background: rgba(21,30,45,0.55);
      display: flex; align-items: center; justify-content: center;
      z-index: 200; opacity: 0; pointer-events: none; transition: opacity .25s;
    }
    .delete-modal-overlay.active { opacity: 1; pointer-events: auto; }
    .delete-modal {
      background: var(--white); border-radius: 12px; padding: 32px;
      max-width: 400px; width: 100%;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
      transform: translateY(16px); transition: transform .25s;
    }
    .delete-modal-overlay.active .delete-modal { transform: translateY(0); }
    .action-menu {
      position: relative; display: inline-block;
    }
    .action-menu-btn {
      background: transparent; border: 1px solid var(--border);
      border-radius: 6px; padding: 6px 10px; cursor: pointer;
      font-size: 16px; line-height: 1; color: var(--text-gray);
      transition: .2s;
    }
    .action-menu-btn:hover { background: var(--bg-gray); color: var(--dark-navy); }
    .action-dropdown {
      position: absolute; right: 0; top: calc(100% + 6px);
      background: var(--white); border: 1px solid var(--border);
      border-radius: 8px; min-width: 160px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      z-index: 99; display: none; overflow: hidden;
    }
    .action-dropdown.open { display: block; }
    .action-dropdown button {
      width: 100%; text-align: left; padding: 10px 16px;
      background: none; border: none; cursor: pointer;
      font-size: 13px; font-weight: 500; color: var(--dark-navy);
      display: flex; align-items: center; gap: 8px; transition: .15s;
    }
    .action-dropdown button:hover { background: var(--bg-gray); }
    .action-dropdown button.danger { color: #ef4444; }
    .action-dropdown button.danger:hover { background: #fee2e2; }
    .empty-state {
      text-align: center; padding: 60px 24px; color: var(--text-gray);
    }
    .empty-state h3 { margin-bottom: 8px; color: var(--dark-navy); }
  </style>
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
      <a href="{{ url('/admin/users') }}{{ url('/admin/schedules') }}" class="active"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer">
      <a href="{{ url('/admin/settings') }}">
        <svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
    </div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; <span>Users</span></div>
      <div class="topbar-right">
        <div class="search-bar">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" id="topbarSearch" placeholder="Search users…">
        </div>
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        </div>
        <div class="admin-profile">
          <div class="admin-info">
            <h4>{{ Auth::user()->user_name }}</h4>
            <p>Super Admin</p>
          </div>
          <div class="admin-avatar">
            <img src="https://placehold.co/40x40/94a3b8/fff?text={{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}" alt="Avatar" style="width:100%;">
          </div>
          <a href="{{ url('/logout') }}" title="Keluar" style="background:#fef2f2;border:1px solid #fecaca;color:#ef4444;padding:6px;border-radius:6px;cursor:pointer;margin-left:8px;text-decoration:none;display:flex;align-items:center;transition:0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          </a>
        </div>
      </div>
    </header>

    <main class="content-area">
      <div class="page-header">
        <main class="content-area">
      
      @if(session('success'))
      <div id="successAlert" style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center; gap: 12px;">
              <span style="font-size: 20px;">✅</span>
              <span style="font-size: 14px; font-weight: 600;">{{ session('success') }}</span>
          </div>
          <button onclick="document.getElementById('successAlert').style.display='none'" style="background: none; border: none; cursor: pointer; font-size: 18px; color: #065f46; opacity: 0.7;">✕</button>
      </div>
      
      <script>
          setTimeout(function() {
              let alertBox = document.getElementById('successAlert');
              if(alertBox) {
                  alertBox.style.transition = 'opacity 0.5s';
                  alertBox.style.opacity = '0';
                  setTimeout(() => alertBox.style.display = 'none', 500);
              }
          }, 4000);
      </script>
      @endif
      <div class="page-header">
        <div>
          <h1>Account Directory</h1>
          <p>Manage all registered campus users and their system access.</p>
        </div>
        <a href="/admin/users/add" class="btn btn-primary" style="display:flex;align-items:center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          New User
        </a>
      </div>

      <div class="table-container">
        <!-- Filter Bar -->
        <div class="flex-between" style="padding:16px 24px;border-bottom:1px solid var(--border);">
          <div style="display:flex;gap:12px;align-items:center;">
            <select id="roleFilter" class="btn btn-outline" style="padding:8px 16px;font-weight:500;cursor:pointer;">
              <option value="all">All Roles</option>
              <option value="Doctor">Doctor</option>
              <option value="Student">Student</option>
              <option value="Admin">Admin</option>
            </select>
            <select id="statusFilter" class="btn btn-outline" style="padding:8px 16px;font-weight:500;cursor:pointer;">
              <option value="all">All Status</option>
              <option value="active">Active</option>
              <option value="offline">Offline</option>
              <option value="suspended">Suspended</option>
            </select>
          </div>
          <span id="userCount" style="font-size:13px;color:var(--text-gray);font-weight:500;"></span>
        </div>

        <table>
          <thead>
            <tr>
              <th>Name &amp; Email</th>
              <th>Role</th>
              <th>ID Number</th>
              <th>Department</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <!-- Avatar simpel dari inisial nama -->
                        <div style="width:40px;height:40px;border-radius:50%;background:#cbd5e1;display:flex;align-items:center;justify-content:center;font-weight:bold;color:white;">
                            {{ strtoupper(substr($user->user_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 style="font-size:14px;color:var(--dark-navy);">{{ $user->user_name }}</h4>
                            <p style="font-size:12px;color:var(--text-gray);">{{ $user->user_email }}</p>
                        </div>
                    </div>
                </td>
                <td style="color:var(--text-gray);">
                    {{-- Terjemahin ID Role ke Nama Role --}}
                    @if($user->id_role == 1) Student 
                    @elseif($user->id_role == 2) Doctor 
                    @elseif($user->id_role == 3) Admin 
                    @else {{ $user->id_role }} 
                    @endif
                </td>
                <td style="color:var(--text-gray);font-size:13px;">{{ $user->id_user }}</td>
                <td style="color:var(--text-gray);font-size:13px;">{{ $user->user_dept }}</td>
                <td>
                    <span class="badge {{ $user->user_status == 'active' ? 'badge-active' : 'badge-suspended' }}">
                        {{ strtoupper($user->user_status) }}
                    </span>
                </td>
                <td>
                    <div class="action-menu" data-uid="{{ $user->id_user }}">
                        <button class="action-menu-btn">⋯</button>
                        <div class="action-dropdown">
                          <a href="{{ url('/admin/users/edit?id='.$user->id_user) }}" style="text-decoration:none; display:block;">
                              <button type="button" style="width:100%; text-align:left;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;color:#64748b;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                Edit Profile
                              </button>
                          </a>
                          <button type="button" class="danger" onclick="munculinModalDelete('{{ $user->id_user }}', '{{ $user->user_name }}')">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                              Delete User
                          </button>
                      </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>

        <div id="emptyState" class="empty-state" style="display:none;">
          <div style="margin-bottom:16px;color:#cbd5e1;display:flex;justify-content:center;">
             <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>No users found</h3>
          <p>Try adjusting your search or filter criteria.</p>
        </div>

        <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);">
          <span id="paginationInfo" style="font-size:13px;color:var(--text-gray);"></span>
          <a href="/admin/users/add" class="btn btn-primary" style="padding:8px 16px;display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New User
          </a>
        </div>
      </div>
    </main>
  </div>

  <div id="deleteModal" class="delete-modal-overlay">
    <div class="delete-modal">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
        <div style="width:40px;height:40px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#ef4444;flex-shrink:0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
        </div>
        <h2 style="font-size:18px;color:var(--dark-navy);">Delete User</h2>
      </div>
      <p style="color:var(--text-gray);font-size:14px;margin-bottom:8px;line-height:1.6;">
        Are you sure you want to permanently delete <strong id="deleteUserName"></strong>?
      </p>
      <p style="color:#ef4444;font-size:12px;margin-bottom:24px;">⚠ This action cannot be undone.</p>
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button id="cancelDelete" class="btn btn-outline">Cancel</button>
        <button id="confirmDelete" style="background:#ef4444;color:white;padding:10px 20px;border:none;border-radius:8px;font-weight:600;font-size:13px;cursor:pointer;">Delete User</button>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script>
    const BADGE = {
      active:    '<span class="badge badge-active">Active</span>',
      offline:   '<span class="badge badge-offline">Offline</span>',
      suspended: '<span class="badge badge-suspended">Suspended</span>',
      'on-leave':'<span class="badge badge-warning">On Leave</span>',
    };

    let pendingDeleteId = null;
    let activeDropdown  = null;

    // ── Close open dropdown when clicking outside ────────────────────────────
    document.addEventListener('click', e => {
      if (activeDropdown && !activeDropdown.contains(e.target)) {
        activeDropdown.querySelector('.action-dropdown')?.classList.remove('open');
        activeDropdown = null;
      }
    });

    document.getElementById('topbarSearch').addEventListener('input', applyFilters);
    document.getElementById('roleFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    // ── Actions ───────────────────────────────────────────────────────────────
    function handleEdit(uid) {
      const users = AppData.getUsers();
      const user  = users.find(u => u.id === uid);
      if (!user) return;
      AppData.setSelectedUser(user);
      window.location.href = '/admin/users/edit';
    }

    function handleToggle(uid) {
      const users = AppData.getUsers();
      const user  = users.find(u => u.id === uid);
      if (!user) return;
      const wasSuspended = user.status === 'suspended';
      user.status = wasSuspended ? 'active' : 'suspended';
      user.lastUpdated = new Date().toLocaleString('en-US', { month:'short', day:'numeric', year:'numeric', hour:'2-digit', minute:'2-digit' });
      AppData.saveUsers(users);
      Toast.show(`${user.name} has been ${wasSuspended ? 'activated' : 'suspended'}.`, wasSuspended ? 'success' : 'warning');
    }

      function munculinModalDelete(id, namaUser) {
          document.getElementById('deleteUserName').textContent = namaUser;
          document.getElementById('deleteModal').classList.add('active');
          document.getElementById('confirmDelete').onclick = function() {
              window.location.href = "/admin/users/delete/" + id;
          };
      }

    document.getElementById('cancelDelete').addEventListener('click', () => {
      document.getElementById('deleteModal').classList.remove('active');
      pendingDeleteId = null;
    });

    document.getElementById('confirmDelete').addEventListener('click', () => {
      if (!pendingDeleteId) return;
      let users = AppData.getUsers();
      const user = users.find(u => u.id === pendingDeleteId);
      users = users.filter(u => u.id !== pendingDeleteId);
      AppData.saveUsers(users);
      document.getElementById('deleteModal').classList.remove('active');
      pendingDeleteId = null;
      Toast.show(`${user?.name} has been deleted.`, 'info');
    });

    // Close delete modal on backdrop click
    document.getElementById('deleteModal').addEventListener('click', e => {
      if (e.target === document.getElementById('deleteModal')) {
        document.getElementById('deleteModal').classList.remove('active');
        pendingDeleteId = null;
      }
    });

  </script>
<script>
(function() {
  const bellWrap = document.querySelector('.bell-wrapper, .icon-btn');
  if (!bellWrap) return;

  function getNotifs() {
    const meds = window.AppData?.getMedicines?.() || [];
    const scheds = window.AppData?.getSchedules?.() || [];
    const patients = window.MOCK_PATIENTS || [];
    const notifs = [];

    meds.filter(m => m.status !== 'in_stock').forEach(m => {
      const isOut = m.status === 'out_of_stock';
      const icon = isOut ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
      notifs.push({ color:'#f97316', title: `<span style="display:flex;align-items:center;">${icon} ${isOut ? 'Out of Stock' : 'Low Stock'}</span>`, body: `${m.name} — ${m.stock} units remaining` });
    });
    scheds.filter(s => s.status === 'leave').forEach(s => {
      notifs.push({ color:'#3b82f6', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Doctor On Leave</span>', body: `${s.doctor} — ${s.department}` });
    });
    patients.filter(p => p.status === 'waiting').slice(0,2).forEach(p => {
      notifs.push({ color:'#529b2e', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Patient Waiting</span>', body: `${p.name} — Queue ${p.queue} • ${p.time}` });
    });
    if (!notifs.length) notifs.push({ color:'#94a3b8', title:'<span style="display:flex;align-items:center;color:#059669;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> All Clear</span>', body: 'No new notifications.' });
    return notifs.slice(0, 6);
  }

  const panel = document.createElement('div');
  panel.className = 'notif-panel';
  panel.innerHTML = '<div class="notif-header"><h4 style="display:flex;align-items:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg> Notifications</h4><span id="clearNotifs">Mark all read</span></div><div id="notifList"></div>';
  bellWrap.style.position = 'relative';
  bellWrap.appendChild(panel);

  function renderNotifs() {
    const list = document.getElementById('notifList');
    if (!list) return;
    list.innerHTML = '';
    getNotifs().forEach(n => {
      const div = document.createElement('div');
      div.className = 'notif-item';
      div.innerHTML = `<div class="notif-dot" style="background:${n.color};"></div><div><h5 style="margin-bottom:4px;">${n.title}</h5><p>${n.body}</p></div>`;
      list.appendChild(div);
    });
  }

  const bellEl = bellWrap.querySelector('.bell, .icon-btn') || bellWrap;
  bellWrap.addEventListener('click', e => {
    e.stopPropagation();
    renderNotifs();
    panel.classList.toggle('open');
  });
  document.addEventListener('click', () => panel.classList.remove('open'));
  document.getElementById('clearNotifs')?.addEventListener('click', () => { panel.classList.remove('open'); });
})();

</script>
<script>
    document.addEventListener('click', e => {
        const btn = e.target.closest('.action-menu-btn');
        if (btn) {
            const dropdown = btn.nextElementSibling;
            dropdown.classList.toggle('open');
            document.querySelectorAll('.action-dropdown.open').forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });
        } else {
            document.querySelectorAll('.action-dropdown.open').forEach(d => d.classList.remove('open'));
        }
    });

    function panggilModalDelete(id, nama) {
        document.getElementById('deleteUserName').textContent = nama;
        document.getElementById('deleteModal').classList.add('active');

        document.getElementById('confirmDelete').onclick = function() {
            window.location.href = "/admin/users/delete/" + id;
        };
    }

    document.getElementById('cancelDelete').onclick = function() {
        document.getElementById('deleteModal').classList.remove('active');
    };

    function applyFilters() {
        const q = document.getElementById('topbarSearch').value.toLowerCase();
        const role = document.getElementById('roleFilter').value.toLowerCase();
        const status = document.getElementById('statusFilter').value.toLowerCase();
        
        const rows = document.querySelectorAll('#userTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const textContent = row.children[0].innerText.toLowerCase();
            const rowRole = row.children[1].innerText.toLowerCase();
            const rowStatus = row.children[4].innerText.toLowerCase();

            const matchQ = textContent.includes(q) || row.children[2].innerText.toLowerCase().includes(q);
            const matchRole = role === 'all' || rowRole.includes(role);
            const matchStatus = status === 'all' || rowStatus.includes(status);

            if (matchQ && matchRole && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptyState');
        const userCount = document.getElementById('userCount');
        const paginationInfo = document.getElementById('paginationInfo');

        if (emptyState) emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        if (userCount) userCount.innerText = `${visibleCount} users found`;
        if (paginationInfo) paginationInfo.innerText = `Showing ${visibleCount} users`;
    }

    document.getElementById('topbarSearch').addEventListener('input', applyFilters);
    document.getElementById('roleFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    document.addEventListener('DOMContentLoaded', applyFilters);
</script>
</body>
</html>
