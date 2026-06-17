<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Today's Patients - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
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
        <div class="bell-wrapper"><div class="icon-btn">🔔</div></div>
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>
        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left;">
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Profile
          </a>
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout
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
            <tr><th>Queue No.</th><th>Patient Name</th><th>Time</th><th>Visit Type</th><th>Status</th><th>Actions</th></tr>
          </thead>
          <tbody id="patientTbody">
            @forelse($patients as $p)
              @php
                  // Hitung umur pasien
                  $age = \Carbon\Carbon::parse($p->date_of_birth)->age;
                  
                  // Label Status
                  $statusLabel = 'Waiting';
                  $badgeClass = 'badge-waiting';
                  if ($p->status == 'I') { $statusLabel = 'In Progress'; $badgeClass = 'badge-consultation'; }
                  if ($p->status == 'F') { $statusLabel = 'Completed'; $badgeClass = 'badge-completed'; }
                  
                  // 🌟 LOGIKA WAKTU (Menyamakan dengan Dashboard - Versi Multi-Shift)
                  $time = '00:00';
                  if (!empty($p->shift)) {
                      $shiftStr = strtolower($p->shift);
                      if (str_contains($shiftStr, 'morning')) {
                          $waktuMulai = strtotime('08:00');
                      } elseif (str_contains($shiftStr, 'afternoon')) {
                          $waktuMulai = strtotime('13:00');
                      } else {
                          $shiftParts = explode(' - ', $p->shift);
                          $waktuMulai = strtotime($shiftParts[0]);
                      }
                      $tambahanMenit = ($p->queue_number - 1) * 30; // Jeda 30 Menit
                      $time = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));
                  }
              @endphp

              <tr class="patient-row" data-status="{{ $p->status }}" style="{{ $p->status == 'F' ? 'display:none;' : '' }}">
                <td><span class="queue-badge">{{ $p->queue_number }}</span></td>
                <td>
                  <div class="patient-cell">
                    <div class="patient-avatar">👤</div>
                    <div class="patient-info">
                      <h4>{{ $p->name }}</h4>
                      <p>{{ $p->gender == 'M' ? 'Male' : 'Female' }}, {{ $age }} yrs</p>
                    </div>
                  </div>
                </td>
                <td>{{ $time }}</td>
                <td><span class="badge" style="color:#9333ea;border:1px solid #9333ea;">Consultation</span></td>
                <td><span class="badge {{ $badgeClass }}">{!! $statusLabel !!}</span></td>
                <td>
                  @if($p->status == 'F')
                      <a href="{{ url('/doctor/records') }}" class="btn btn-outline" style="color:var(--primary-green); border-color:var(--primary-green);">View Record</a>
                  @else
                      <a href="{{ url('/doctor/new-entry?appointment_id=' . $p->id_appointments) }}" class="btn btn-primary">Start Exam</a>
                  @endif
                </td>
              </tr>
            @empty
              @endforelse
          </tbody>
        </table>
        
        <div id="emptyState" class="empty-state" style="{{ $remainingCount > 0 ? 'display:none;' : '' }}">
          No patients found for this category.
        </div>
      </div>
      <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);font-size:13px;color:var(--text-gray);">
        <span>Showing <strong id="showing-count">{{ $remainingCount }}</strong> records</span>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    // 1. Script Profil Dropdown
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

    // 2. 🌟 SCRIPT BARU: Gabungan Filter Tab & Search Bar!
    function filterTable() {
        const searchQuery = document.getElementById('searchPatients').value.toLowerCase();
        const activeFilter = document.querySelector('.btn-filter-active').getAttribute('data-filter');
        const rows = document.querySelectorAll('.patient-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status'); // W, I, atau C
            const rowText = row.textContent.toLowerCase(); // Ambil semua teks di baris itu
            let matchFilter = false;

            // Cek kondisi Tab
            if (activeFilter === 'all') matchFilter = true;
            else if (activeFilter === 'queue' && (status === 'W' || status === 'I')) matchFilter = true;
            else if (activeFilter === 'done' && status === 'F') matchFilter = true;

            // Cek kondisi Search (Gabungkan)
            if (matchFilter && rowText.includes(searchQuery)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update tulisan angka di bawah tabel
        document.getElementById('showing-count').textContent = visibleCount;
        
        // Tampilkan pesan kosong jika tidak ada baris yang muncul
        if(visibleCount === 0) {
            document.getElementById('emptyState').style.display = 'block';
        } else {
            document.getElementById('emptyState').style.display = 'none';
        }
    }

    // Pasang alat pendeteksi klik di Tab
    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('btn-filter-active'));
            this.classList.add('btn-filter-active');
            filterTable(); // Panggil fungsi saringan
        });
    });

    // Pasang alat pendeteksi ketikan di Search Bar
    document.getElementById('searchPatients').addEventListener('input', filterTable);

  </script>
</body>
</html>