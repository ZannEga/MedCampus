<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedules - MedCampus Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    /* CSS UNTUK NOTIFIKASI */
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
    
    /* CSS UNTUK MENU AKSI */
    .action-menu{position:relative;display:inline-block}
    .action-menu-btn{background:transparent;border:1px solid var(--border);border-radius:6px;padding:6px 10px;cursor:pointer;font-size:16px;color:var(--text-gray);transition:.2s}
    .action-menu-btn:hover{background:var(--bg-gray)}

    /* CSS UNTUK MODAL DELETE CUSTOM */
    .del-overlay { position:fixed; inset:0; background:rgba(21,30,45,.55); display:flex; align-items:center; justify-content:center; z-index:2000; opacity:0; pointer-events:none; transition:opacity .2s ease-in-out; }
    .del-overlay.active { opacity:1; pointer-events:auto; }
    .del-card { background:#fff; border-radius:12px; padding:28px 32px; max-width:400px; width:100%; box-shadow:0 20px 40px rgba(0,0,0,.15); transform:translateY(20px); transition:transform .2s ease-in-out; }
    .del-overlay.active .del-card { transform:translateY(0); }
  </style>
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg> MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}" class="active"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; <span>Schedules</span></div>
      <div class="topbar-right">
        <div class="search-bar"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><input type="text" id="searchInput" placeholder="Search doctors or departments…"></div>
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
        <div><h1>Clinical Schedules</h1><p>Manage routine practitioner shifts and clinic availability.</p></div>
        <a href="{{ url('/admin/schedules/add') }}" class="btn btn-primary" style="display:flex;align-items:center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Add Schedule
        </a>
      </div>

      <div class="flex-between" style="background:var(--white);padding:16px 24px;border-radius:12px;border:1px solid var(--border);margin-bottom:24px;">
        <div style="display:flex;gap:8px;">
          <button class="btn btn-primary" id="btnWeekly">Weekly View</button>
          <button class="btn btn-outline" id="btnList">List View</button>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
          <span style="font-size:13px;font-weight:700;color:var(--text-gray);text-transform:uppercase;">Filter:</span>
          <select id="deptFilter" class="admin-form-select" style="padding:8px 32px 8px 16px;width:200px;background-color:var(--white);cursor:pointer;">
            <option value="all">All Departments</option>
            <option value="Cardiology">Cardiology</option>
            <option value="Neurology">Neurology</option>
            <option value="Pediatrics">Pediatrics</option>
            <option value="General Medicine">General Medicine</option>
            <option value="Dental Clinic">Dental Clinic</option>
          </select>
          <select id="statusFilter" class="admin-form-select" style="padding:8px 32px 8px 16px;width:160px;background-color:var(--white);cursor:pointer;">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="leave">On Leave</option>
          </select>
        </div>
      </div>

      <div id="weeklyHeader" class="table-container" style="border-radius:12px 12px 0 0;border-bottom:none;margin-bottom:0;">
        <div class="admin-schedule-header" id="weekHeader"></div>
      </div>

      <div class="table-container" style="border-radius:0 0 12px 12px;">
        <table>
          <thead><tr><th>Doctor</th><th>Department</th><th>Shift &amp; Time</th><th>Room</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody id="schedBody">
            @foreach($schedules as $sch)
            <tr class="schedule-row" data-date="{{ \Carbon\Carbon::parse($sch->schedule_date)->format('Y-m-d') }}">
              <td>
                <div style="display:flex;align-items:center;gap:12px;">
                  <div style="width:40px;height:40px;background:#cbd5e1;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:16px;flex-shrink:0;">
                    {{ strtoupper(substr($sch->user_name ?? 'DR', 0, 2)) }}
                  </div>
                  <div>
                    <h4 style="font-size:14px;color:var(--dark-navy);">{{ $sch->user_name }}</h4>
                    <p style="font-size:11px;color:var(--text-gray);">ID: {{ $sch->id_user }}</p>
                  </div>
                </div>
              </td>
              <td><span class="badge" style="background:var(--bg-gray);color:var(--text-gray);">{{ $sch->user_dept ?? $sch->department }}</span></td>
              
              <td>
                <div style="font-weight:600; color:var(--dark-navy); margin-bottom:4px; display:flex; align-items:center;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:6px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  {{ $sch->shift }}
                </div>
                <div style="font-size:12px; color:var(--text-gray); display:flex; align-items:center;">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                  {{ \Carbon\Carbon::parse($sch->schedule_date)->format('d M Y') }}
                </div>
              </td>

              <td style="color:var(--text-gray);font-size:13px;">{{ $sch->room }}</td>
              <td><span class="badge" style="border:1px solid var(--primary-green);color:var(--primary-green);background:transparent;">Active</span></td>
              <td>
                <div class="action-menu" style="display:flex;gap:12px;">
                  <a href="{{ url('/admin/schedules/edit/' . $sch->id_schedule) }}" style="text-decoration:none;color:#64748b;display:flex;align-items:center;" title="Edit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  </a>
                  <a href="javascript:void(0)" onclick="openDeleteModal('{{ url('/admin/schedules/delete/' . $sch->id_schedule) }}')" style="text-decoration:none;color:#ef4444;display:flex;align-items:center;" title="Delete">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        <div id="emptyState" style="text-align:center;padding:60px 24px;color:var(--text-gray);display:none;">
          <div style="margin-bottom:12px;color:#cbd5e1;display:flex;justify-content:center;">
             <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3 style="color:var(--dark-navy);margin-bottom:8px;">No schedules found</h3>
          <p>Try adjusting your filters or <a href="{{ url('/admin/schedules/add') }}" style="color:var(--primary-green);font-weight:600;">add a new schedule</a>.</p>
        </div>
        
        <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);">
          <span id="countLabel" style="font-size:13px;color:var(--text-gray);"></span>
          <a href="{{ url('/admin/schedules/add') }}" class="btn btn-primary" style="padding:8px 16px;display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Schedule
          </a>
        </div>
      </div>
    </main>

    <div id="customDeleteModal" class="del-overlay">
      <div class="del-card">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
          <div style="width:48px;height:48px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#ef4444;flex-shrink:0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
          </div>
          <h2 style="font-size:20px;font-weight:700;color:var(--dark-navy);margin:0;">Delete Schedule</h2>
        </div>
        <p style="color:#475569;font-size:15px;margin-bottom:12px;line-height:1.5;">Are you sure you want to permanently delete this schedule?</p>
        <p style="color:#ef4444;font-size:13px;margin-bottom:28px;">⚠ This action cannot be undone.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
          <button onclick="closeDeleteModal()" style="padding:10px 24px;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;border:1px solid #cbd5e1;background:#fff;color:#475569;transition:.2s;">Cancel</button>
          <a href="#" id="confirmDeleteBtn" style="background:#ef4444;color:white;padding:10px 24px;border:none;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;text-decoration:none;transition:.2s;">Delete Schedule</a>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    let currentView = 'weekly'; 
    let selectedDate = '';      

    // FUNGSI UNTUK MEMBUKA MODAL DELETE
    function openDeleteModal(deleteUrl) {
        document.getElementById('confirmDeleteBtn').href = deleteUrl; 
        document.getElementById('customDeleteModal').classList.add('active');
    }
    // FUNGSI UNTUK MENUTUP MODAL DELETE
    function closeDeleteModal() {
        document.getElementById('customDeleteModal').classList.remove('active');
    }

    function applyFilters() {
      // 🌟 1. Pastikan semua pencarian diubah ke huruf kecil (toLowerCase)
      const q      = document.getElementById('searchInput') ? document.getElementById('searchInput').value.toLowerCase() : '';
      const dept   = document.getElementById('deptFilter') ? document.getElementById('deptFilter').value.toLowerCase() : 'all';
      const status = document.getElementById('statusFilter') ? document.getElementById('statusFilter').value.toLowerCase() : 'all'; // 🌟 TAMBAHAN: Ambil nilai filter Status
      
      const rows = document.querySelectorAll('.schedule-row');
      let visibleCount = 0;

      rows.forEach(row => {
        // 🌟 2. Ambil teks dari baris dan ubah ke huruf kecil juga biar cocok
        const text       = row.innerText.toLowerCase();
        const deptText   = row.children[1] ? row.children[1].innerText.toLowerCase() : '';
        const statusText = row.children[4] ? row.children[4].innerText.toLowerCase() : ''; // 🌟 TAMBAHAN: Ambil kolom ke-5 (Status)
        const rowDate    = row.getAttribute('data-date');

        // 🌟 3. Logika Pencocokan
        const matchQ      = text.includes(q);
        const matchDept   = dept === 'all' || deptText.includes(dept);
        const matchStatus = status === 'all' || statusText.includes(status); // 🌟 TAMBAHAN: Cek kecocokan status
        
        let matchDate = true;
        if (currentView === 'weekly' && selectedDate !== '') {
            matchDate = (rowDate === selectedDate);
        }

        // 🌟 4. Gabungkan semua syaratnya (TERMASUK STATUS!)
        if (matchQ && matchDept && matchStatus && matchDate) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      const emptyState = document.getElementById('emptyState');
      const countLabel = document.getElementById('countLabel');
      
      if (emptyState) emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
      
      if (countLabel) {
          if (currentView === 'weekly') {
              const activeTab = document.querySelector('.admin-schedule-day.active');
              const dayName = activeTab ? activeTab.querySelector('.admin-schedule-day-name').innerText : '';
              const dayNum = activeTab ? activeTab.querySelector('.admin-schedule-day-date').innerText : '';
              countLabel.textContent = `Showing ${visibleCount} schedules for ${dayName} ${dayNum}`;
          } else {
              countLabel.textContent = `Showing ${visibleCount} total schedules`;
          }
      }
    }

    function buildWeekHeader() {
      const header = document.getElementById('weekHeader');
      if (!header) return;
      const days   = ['MON','TUE','WED','THU','FRI','SAT','SUN'];
      header.innerHTML = '';

      let curr = new Date();
      let first = curr.getDate() - curr.getDay() + (curr.getDay() === 0 ? -6 : 1);
      let monday = new Date(curr.setDate(first));

      days.forEach((d, i) => {
        let currentDay = new Date(monday);
        currentDay.setDate(monday.getDate() + i);

        // 🌟 PERBAIKAN: Ambil tanggal lokal (WIB), bukan UTC!
        let y = currentDay.getFullYear();
        let m = String(currentDay.getMonth() + 1).padStart(2, '0');
        let dNum = String(currentDay.getDate()).padStart(2, '0');
        let dateString = `${y}-${m}-${dNum}`; 

        let dayNum = currentDay.getDate();
        let isToday = new Date().toDateString() === currentDay.toDateString();

        const div = document.createElement('div');
        div.className = 'admin-schedule-day' + (isToday ? ' active' : '');
        div.style.cursor = 'pointer'; 
        div.dataset.date = dateString;

        div.innerHTML = `<div class="admin-schedule-day-name" style="${isToday?'color:var(--primary-green);':''}">${d}</div><div class="admin-schedule-day-date">${dayNum}</div>`;

        div.addEventListener('click', function() {
            document.querySelectorAll('.admin-schedule-day').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            
            selectedDate = this.dataset.date;
            currentView = 'weekly'; 
            localStorage.setItem('savedScheduleView', 'weekly');
            
            document.getElementById('btnWeekly').className = 'btn btn-primary';
            document.getElementById('btnList').className = 'btn btn-outline';
            document.getElementById('weeklyHeader').style.display = '';

            applyFilters();
        });

        header.appendChild(div);
      });

      // Menjalankan klik otomatis saat tidak berada di mode List View
      setTimeout(() => {
        if(localStorage.getItem('savedScheduleView') !== 'list') {
            const todayTab = document.querySelector('.admin-schedule-day.active');
            if(todayTab) todayTab.click();
        }
      }, 100);
    }

    const btnWeekly = document.getElementById('btnWeekly');
    const btnList = document.getElementById('btnList');

    if (btnWeekly && btnList) {
        btnWeekly.addEventListener('click', () => {
          btnWeekly.className = 'btn btn-primary';
          btnList.className = 'btn btn-outline';
          document.getElementById('weeklyHeader').style.display = '';
          
          currentView = 'weekly';
          localStorage.setItem('savedScheduleView', 'weekly');

          const activeTab = document.querySelector('.admin-schedule-day.active') || document.querySelector('.admin-schedule-day');
          if(activeTab) {
              selectedDate = activeTab.dataset.date;
              activeTab.classList.add('active');
          }
          applyFilters();
        });

        btnList.addEventListener('click', () => {
          btnList.className = 'btn btn-primary';
          btnWeekly.className = 'btn btn-outline';
          document.getElementById('weeklyHeader').style.display = 'none';
          
          currentView = 'list';
          localStorage.setItem('savedScheduleView', 'list');
          applyFilters(); 
        });
    }

    const searchInput = document.getElementById('searchInput');
    const deptFilter = document.getElementById('deptFilter');
    
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (deptFilter) deptFilter.addEventListener('change', applyFilters);

    document.addEventListener('DOMContentLoaded', () => {
      buildWeekHeader();
      
      // Jika memori mengatakan user sedang di List View, panggil aksi tombol List View
      if(localStorage.getItem('savedScheduleView') === 'list') {
          setTimeout(() => {
              if (btnList) btnList.click();
          }, 150);
      }
    });
  </script>

  <script>
    (function() {
      const bellWrap = document.querySelector('.bell-wrapper');
      if (!bellWrap) return;

      const panel = document.createElement('div');
      panel.className = 'notif-panel';
      panel.innerHTML = '<div class="notif-header"><h4 style="display:flex;align-items:center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg> Notifications</h4><span id="clearNotifs">Mark all read</span></div><div id="notifList"></div>';
      bellWrap.style.position = 'relative';
      bellWrap.appendChild(panel);

      function renderNotifs() {
        const list = document.getElementById('notifList');
        if (!list) return;
        list.innerHTML = '';
        const notifs = [
            { color:'#94a3b8', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#059669;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> All Clear</span>', body: 'No new notifications right now.' }
        ];
        notifs.forEach(n => {
          const div = document.createElement('div');
          div.className = 'notif-item';
          div.innerHTML = `<div class="notif-dot" style="background:${n.color};"></div><div><h5 style="margin-bottom:4px;">${n.title}</h5><p>${n.body}</p></div>`;
          list.appendChild(div);
        });
      }

      bellWrap.addEventListener('click', e => {
        e.stopPropagation();
        renderNotifs();
        panel.classList.toggle('open');
      });
      document.addEventListener('click', () => panel.classList.remove('open'));
      document.getElementById('clearNotifs')?.addEventListener('click', () => { panel.classList.remove('open'); });
    })();
  </script>
</body>
</html>