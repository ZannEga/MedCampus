<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Dashboard - MedCampus</title>
  <style>
    /* CSS Notifikasi */
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
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
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
          <input type="text" placeholder="Search patients…" id="dashSearch">
        </div>
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}" class="active">Dashboard</a>
        <a href="{{ url('/doctor/patients') }}">Today's Patients</a>
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
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);margin-left:2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
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

  <main class="main-content container">
    <div style="margin-bottom:32px;">
      <h1 style="font-size:32px;margin-bottom:8px;">Welcome, {{ Auth::user()->user_name }}</h1>
      <p style="color:var(--text-gray);font-size:16px;">University Health System Dashboard • <span style="color:var(--primary-green);font-weight:500;" id="dash-date"></span></p>
    </div>

    <div class="grid-3" style="margin-bottom:32px;">
      <div class="card stat-card">
        <div class="stat-header">
          <span class="stat-title">Patients Today</span>
          <div class="stat-icon" style="background: var(--bg-gray);display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
        </div>
        <div>
          <div class="stat-value">{{ $totalPatients }}</div>
          <div class="stat-desc"><span class="stat-trend-up">Real-time Data</span></div>
        </div>
      </div>
      <div class="card stat-card">
        <div class="stat-header">
          <span class="stat-title">Pending Exams</span>
          <div class="stat-icon" style="background: var(--bg-gray);color:#d97706;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          </div>
        </div>
        <div>
          <div class="stat-value">{{ $pendingExams }}</div>
          <div class="stat-desc">Waiting in queue</div>
        </div>
      </div>
      <div class="card stat-card">
        <div class="stat-header">
          <span class="stat-title">Completed</span>
          <div class="stat-icon" style="background: var(--bg-gray);color:#16a34a;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          </div>
        </div>
        <div>
          <div class="stat-value">{{ $completedExams }}</div>
          @php $percent = $totalPatients > 0 ? round(($completedExams / $totalPatients) * 100) : 0; @endphp
          <div style="width:100%;height:6px;background:var(--bg-gray);border-radius:4px;margin-top:12px;overflow:hidden;">
            <div style="height:100%;background:var(--primary-green);border-radius:4px;width:{{ $percent }}%;transition:width 0.6s;"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-2">
      <div class="card" style="padding:0;overflow:hidden;">
        <div class="flex-between" style="padding:24px;border-bottom:1px solid var(--border);">
          <h2 style="font-size:18px;">Next in Queue</h2>
          <a href="{{ url('/doctor/patients') }}" style="color:var(--primary-green);font-size:14px;font-weight:600;">View All</a>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr><th>Queue</th><th>Patient Name</th><th>Time</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody id="dashTbody">
                @forelse($todaysPatients as $p)
                    @php
                        $statusText = ($p->status == 'W') ? 'Waiting' : (($p->status == 'F') ? 'Completed' : 'Cancelled');
                        $statusClass = ($p->status == 'W') ? 'badge-waiting' : (($p->status == 'F') ? 'badge-completed' : 'badge-suspended');
                        $btnLabel = ($p->status == 'F') ? 'View Record' : 'Start Exam';
                        $btnClass = ($p->status == 'F') ? 'btn-outline' : 'btn-primary';
                        $age = $p->date_of_birth ? \Carbon\Carbon::parse($p->date_of_birth)->age : '?';
                        
                        $time = $p->booking_time ? date('H:i', strtotime($p->booking_time)) : '—';
                    @endphp
                    <tr>
                        <td><span class="queue-badge">{{ $p->queue_number }}</span></td>
                        <td><div class="patient-info"><h4>{{ $p->name }}</h4><p>{{ $p->gender ?? '-' }}, {{ $age }}y</p></div></td>
                        <td>{{ $time }} WIB</td>
                        <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                        <td>
                            @if($p->status == 'F')
                                <a href="{{ url('/doctor/records') }}?appointment_id={{ $p->id_appointments }}" 
                                  class="btn btn-outline" 
                                  style="text-decoration:none;">
                                    View Record
                                </a>
                            @elseif($p->status == 'W')
                                <a href="{{ url('/doctor/new-entry') }}?appointment_id={{ $p->id_appointments }}" 
                                  class="btn btn-primary" 
                                  style="text-decoration:none;" 
                                  onclick="sessionStorage.setItem('mc_entry_origin','{{ url('/doctor/dashboard') }}');">
                                    Start Exam
                                </a>
                            @else
                                <span class="badge badge-suspended">No Action</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-gray);">No appointments scheduled for today.</td></tr>
                @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div>
        <div class="card clinic-info-card">
          <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:24px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path></svg>
            Clinic Info
          </h3>
          <div class="info-row">
            <div class="info-label">Room</div>
            <div class="info-value">{{ $todaySchedule ? $todaySchedule->room : 'No shift today' }}</div>
          </div>
          <div class="info-row">
            <div class="info-label">Current Shift</div>
            <div class="info-value">{{ $todaySchedule ? $todaySchedule->shift : '-' }}</div>
          </div>
        </div>
        <div>
          <h3 style="font-size:14px;color:var(--text-gray);text-transform:uppercase;margin-bottom:16px;letter-spacing:0.5px;">Quick Links</h3>
          <a href="{{ url('/doctor/schedule') }}" class="quick-link-item" style="display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;color:var(--primary-green);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            View Full Schedule
          </a>
          <a href="{{ url('/doctor/records') }}" class="quick-link-item" style="display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;color:var(--primary-green);"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
            Access Medical Records
          </a>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.getElementById('dash-date').textContent = new Date().toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
  </script>

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