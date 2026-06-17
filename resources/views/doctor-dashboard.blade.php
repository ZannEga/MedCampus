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
        
        <div class="bell-wrapper">
          <div class="icon-btn">🔔</div>
        </div>
        
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>

        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left;">
          
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            My Profile
          </a>
          
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
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
          <div class="stat-icon">👥</div>
        </div>
        <div>
          <div class="stat-value">{{ $totalPatients }}</div>
          <div class="stat-desc"><span class="stat-trend-up">Real-time Data</span></div>
        </div>
      </div>
      <div class="card stat-card">
        <div class="stat-header">
          <span class="stat-title">Pending Exams</span>
          <div class="stat-icon" style="background:#fffbeb;color:#d97706;">📋</div>
        </div>
        <div>
          <div class="stat-value">{{ $pendingExams }}</div>
          <div class="stat-desc">Waiting in queue</div>
        </div>
      </div>
      <div class="card stat-card">
        <div class="stat-header">
          <span class="stat-title">Completed</span>
          <div class="stat-icon" style="background:#f0fdf4;color:#16a34a;">✅</div>
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
                        $statusText = $p->status == 'W' ? 'Waiting' : ($p->status == 'I' ? 'In Progress' : 'Completed');
                        $statusClass = $p->status == 'W' ? 'badge-waiting' : ($p->status == 'I' ? 'badge-consultation' : 'badge-completed');
                        $btnLabel = $p->status == 'W' ? 'Start Exam' : ($p->status == 'I' ? 'Resume' : 'View Record');
                        $btnClass = $p->status == 'C' ? 'btn-outline' : 'btn-primary';
                        $age = $p->date_of_birth ? \Carbon\Carbon::parse($p->date_of_birth)->age : '?';
                        
                        // 🌟 LOGIKA WAKTU (Menyelesaikan bug 00:00)
                        $time = '00:00';
                        if ($todaySchedule && !empty($todaySchedule->shift)) {
                            $shiftStr = strtolower($todaySchedule->shift);
                            if (str_contains($shiftStr, 'morning')) {
                                $waktuMulai = strtotime('08:00');
                            } elseif (str_contains($shiftStr, 'afternoon')) {
                                $waktuMulai = strtotime('13:00');
                            } else {
                                $shiftParts = explode(' - ', $todaySchedule->shift);
                                $waktuMulai = strtotime($shiftParts[0]);
                            }
                            $tambahanMenit = ($p->queue_number - 1) * 30;
                            $time = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));
                        }
                    @endphp
                    <tr>
                        <td><span class="queue-badge">{{ $p->queue_number }}</span></td>
                        <td><div class="patient-info"><h4>{{ $p->name }}</h4><p>{{ $p->gender ?? '-' }}, {{ $age }}y</p></div></td>
                        <td>{{ $time }}</td>
                        <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                        <td>
                            @if($p->status == 'C')
                                <a href="{{ url('/doctor/records') }}" 
                                  class="btn {{ $btnClass }}" 
                                  style="text-decoration:none;">
                                    {{ $btnLabel }}
                                </a>
                            @else
                                <a href="{{ url('/doctor/new-entry') }}?appointment_id={{ $p->id_appointments }}" 
                                  class="btn {{ $btnClass }}" 
                                  style="text-decoration:none;" 
                                  onclick="sessionStorage.setItem('mc_entry_origin','{{ url('/doctor/dashboard') }}');">
                                    {{ $btnLabel }}
                                </a>
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
          <h3 style="display:flex;align-items:center;gap:8px;margin-bottom:24px;"><span>🏥</span> Clinic Info</h3>
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
          <a href="{{ url('/doctor/schedule') }}" class="quick-link-item">📅 View Full Schedule</a>
          <a href="{{ url('/doctor/records') }}" class="quick-link-item">🗂 Access Medical Records</a>
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
</body>
</html>