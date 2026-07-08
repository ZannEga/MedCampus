<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Today's Patients - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
  <style>
    .btn-filter-active {
      border-color: var(--primary-green) !important;
      color: var(--primary-green) !important;
      background: var(--light-green) !important;
      font-weight: 600;
    }
    .empty-state {
      padding: 40px; text-align: center; color: var(--text-gray);
      background: var(--bg-gray); border-radius: 8px; font-size: 14px;
    }

    .notif-panel { position:absolute; right:0; top:calc(100% + 8px); width:320px; background:var(--white); border:1px solid var(--border); border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200; display:none; overflow:hidden; }
    .notif-panel.open { display:block; }
    .notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .notif-header h4 { font-size:14px; font-weight:700; margin:0; }
    .notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
    .notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
    .notif-item:hover { background:var(--bg-gray); }
    .notif-item:last-child { border-bottom:none; }
    .notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
    .notif-item h5 { font-size:13px; margin-bottom:3px; margin-top:0; }
    .notif-item p  { font-size:11px; color:var(--text-gray); margin:0; }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-left">
        <div class="nav-logo">
          <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
          MedCampus
        </div>
        <div class="search-bar">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" placeholder="Search patients…" id="searchPatients">
        </div>
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}">Dashboard</a>
        <a href="{{ url('/doctor/patients') }}" class="active">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}">Schedule</a>
      </div>
      <div class="nav-profile" style="position: relative; display: flex; align-items: center; gap: 16px;">
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        </div>
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>
        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: var(--white); width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left; transition: 0.3s;">
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> 
            My Profile
          </a>
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> 
            Logout
          </a>
        </div>
      </div>
    </div>
  </nav>

  @php
      $totalPatients = count($patients);
      $completedCount = collect($patients)->where('status', 'F')->count();
      $remainingCount = $totalPatients - $completedCount;
      $todayDate = now()->format('l, M jS');
  @endphp

  <main class="main-content container">
    <div class="flex-between" style="margin-bottom:32px;align-items:flex-end;">
      <div>
        <h1 style="font-size:32px;margin-bottom:8px;">Today's Patients</h1>
        <p style="color:var(--text-gray);font-size:14px;">Clinical Appointments • <span style="color:var(--primary-green);font-weight:600;">{{ $remainingCount }} patients remaining</span></p>
      </div>
      <div style="display:flex;gap:12px;">
        <button class="btn btn-outline btn-filter btn-filter-active" data-filter="queue">In Queue</button>
        <button class="btn btn-outline btn-filter" data-filter="done">Completed</button>
        <button class="btn btn-outline btn-filter" data-filter="all">All Appointments</button>
      </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden;margin-bottom:40px;">
      <div class="table-container">
        <table>
          <thead>
            <tr><th>Queue No.</th><th>Patient Name</th><th>Time</th><th>Status</th><th>Actions</th></tr>
          </thead>
          <tbody id="patientsTbody">
                @forelse($patients as $p)
                    @php
                        $statusText = $p->status == 'W' ? 'Waiting' : ($p->status == 'I' ? 'In Progress' : 'Completed');
                        $statusClass = $p->status == 'W' ? 'badge-waiting' : ($p->status == 'I' ? 'badge-consultation' : 'badge-completed');
                        $btnLabel = $p->status == 'W' ? 'Start Exam' : ($p->status == 'I' ? 'Resume' : 'View Record');
                        $btnClass = ($p->status == 'C' || $p->status == 'F') ? 'btn-outline' : 'btn-primary';
                        $age = $p->date_of_birth ? \Carbon\Carbon::parse($p->date_of_birth)->age : '?';
                        
                        $time = $p->booking_time ? date('H:i', strtotime($p->booking_time)) : '—';
                    @endphp
                    <tr class="patient-row" data-status="{{ $p->status }}">
                        <td><span class="queue-badge">{{ $p->queue_number }}</span></td>
                        <td><div class="patient-info"><h4>{{ $p->name }}</h4><p>{{ $p->gender ?? '-' }}, {{ $age }}y</p></div></td>
                        <td>{{ $time }} WIB</td>
                        <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                        <td>
                            @if($p->status == 'C' || $p->status == 'F')
                                <a href="{{ url('/doctor/records') }}?appointment_id={{ $p->id_appointments }}" 
                                  class="btn {{ $btnClass }}" 
                                  style="text-decoration:none;">
                                  {{ $btnLabel }}
                                </a>
                            @else
                                <a href="{{ url('/doctor/new-entry') }}?appointment_id={{ $p->id_appointments }}" 
                                  class="btn {{ $btnClass }}" 
                                  style="text-decoration:none;">
                                  {{ $btnLabel }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-gray);">No patients found for today.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <div id="emptyState" class="empty-state" style="{{ $remainingCount > 0 ? 'display:none;' : '' }} padding:60px 24px; background:transparent; border:1px dashed var(--border);">
          <div style="margin-bottom:12px;color:#cbd5e1;display:flex;justify-content:center;">
             <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><line x1="9" y1="14" x2="15" y2="14"></line><line x1="9" y1="10" x2="15" y2="10"></line></svg>
          </div>
          <h3 style="color:var(--dark-navy);font-size:16px;margin-bottom:4px;">No Patients Found</h3>
          <p style="font-size:13px;color:var(--text-gray);margin:0;">There are no patients matching your current filter.</p>
        </div>
      </div>
      <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);font-size:13px;color:var(--text-gray);">
        <span>Showing <strong id="showing-count">{{ $remainingCount }}</strong> records</span>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    function toggleProfileDropdown(event) {
        if (event) event.stopPropagation();
        const drop = document.getElementById('mcProfileDropdown');
        drop.style.display = (drop.style.display === 'none' || drop.style.display === '') ? 'flex' : 'none';
    }
    
    document.addEventListener('click', function(e) {
        const drop = document.getElementById('mcProfileDropdown');
        const trigger = document.getElementById('mcProfileToggle');
        if (drop && drop.style.display === 'flex') {
            if (!trigger.contains(e.target) && !drop.contains(e.target)) {
                drop.style.display = 'none';
            }
        }
    });

    function filterTable() {
        const searchQuery = document.getElementById('searchPatients').value.toLowerCase();
        const activeFilter = document.querySelector('.btn-filter-active').getAttribute('data-filter');
        const rows = document.querySelectorAll('.patient-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const rowText = row.textContent.toLowerCase();
            let matchFilter = false;

            if (activeFilter === 'all') matchFilter = true;
            else if (activeFilter === 'queue' && (status === 'W' || status === 'I')) matchFilter = true;
            else if (activeFilter === 'done' && status === 'F') matchFilter = true;

            if (matchFilter && rowText.includes(searchQuery)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('showing-count').textContent = visibleCount;
        
        if(visibleCount === 0) {
            document.getElementById('emptyState').style.display = 'block';
        } else {
            document.getElementById('emptyState').style.display = 'none';
        }
    }

    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('btn-filter-active'));
            this.classList.add('btn-filter-active');
            filterTable();
        });
    });

    document.getElementById('searchPatients').addEventListener('input', filterTable);

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
            { color:'#3b82f6', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#2563eb;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Reminder</span>', body: 'Afternoon shift begins in 30 mins.' }
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