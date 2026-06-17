<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}" class="active">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
        <a href="{{ url('/patient/history') }}">Medical History</a>
      </div>
      <div class="nav-profile" style="position: relative;">
        <div class="bell-wrapper">
          <span class="bell">🔔</span>
        </div>
        
        <!-- Tombol Profil Utama -->
        <div id="mcProfileToggle" onclick="toggleDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px; margin-left:16px; border: 1px solid var(--border);">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-right: 4px;">▼</span>
        </div>

        <!-- Menu Dropdown Pop-up -->
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: white; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <!-- Info Singkat di dalam Dropdown -->
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: #f8fafc;">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <!-- Link Menu -->
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;">
            <span>👤</span> My Profile
          </a>
          
          <!-- Tombol Logout -->
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);">
            <span>🚪</span> Logout
          </a>
        </div>
      </div>

      <!-- Script Interaksi Dropdown -->
      <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('mcDropdownMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
        
        // Auto-close jika klik sembarang tempat di layar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mcDropdownMenu');
            const toggle = document.getElementById('mcProfileToggle');
            if (menu && !menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
      </script>
    </div>
  </nav>

  <main class="main-content container">
    <div class="hero-dashboard">
      <h1 id="dash-welcome">Welcome, {{ explode(' ', Auth::user()->user_name)[0] }}!</h1>
      <p>Your health is our top priority at MedCampus Clinic. Track your queue and access medical services with ease.</p>
      <a href="{{ url('/service-guide') }}" class="btn btn-primary">Service Guide</a>
    </div>

    <div class="flex-between" style="margin-bottom:20px;">
      <h2 class="section-title" style="margin:0;">Your Active Queue</h2>
      <span style="font-size:13px;color:var(--primary-green);font-weight:600;">Updated: {{ now()->format('h:i A') }}</span>
    </div>

    <!-- 🌟 LOGIKA BLADE: Cek apakah pasien punya antrean aktif di database -->
    @if(!$activeQueue)
      <!-- STATE: TIDAK ADA ANTREAN -->
      <div id="noQueueState" style="text-align:center;padding:60px 24px;background:var(--white);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:48px;margin-bottom:16px;">📭</div>
        <h3 style="font-size:20px;margin-bottom:8px;">No Active Queue</h3>
        <p style="color:var(--text-gray);margin-bottom:24px;">You don't have any upcoming appointments today.</p>
        <a href="{{ url('/patient/booking') }}" class="btn btn-primary">⊕ Book an Appointment</a>
      </div>
    @else
      <!-- STATE: ADA ANTREAN AKTIF -->
      <div id="queueCard" class="queue-card card-shadow">
        <div class="queue-number-box">
          <span>Queue Number</span>
          <h2>{{ $activeQueue->queue_number }}</h2>
        </div>
        <div class="queue-details">
          <div style="display:flex;gap:12px;align-items:center;margin-bottom:16px;">
            @if($activeQueue->status == 'I')
              <span class="badge" style="background:#fef3c7;color:#d97706;">🔄 In Progress</span>
            @else
              <span class="badge badge-waiting">🕒 Waiting</span>
            @endif
            <span style="font-size:13px;color:var(--text-gray);">• {{ \Carbon\Carbon::parse($activeQueue->appointment_date)->format('M d, Y') }}</span>
          </div>
          <div class="grid-2">
            <div>
              <p style="font-size:11px;color:var(--text-gray);text-transform:uppercase;font-weight:700;">Clinic</p>
              <p style="font-weight:600;">{{ $activeQueue->clinic }}</p>
            </div>
            <div>
              <p style="font-size:11px;color:var(--text-gray);text-transform:uppercase;font-weight:700;">Doctor</p>
              <p style="font-weight:600;">{{ $activeQueue->doctor_name }}</p>
            </div>
          </div>
          <div style="margin-top:16px;color:var(--primary-green);font-weight:500;font-size:14px;">
            ⏱ Estimated Service Time: <span>{{ $estimatedTime }} WIB</span>
          </div>
        </div>
        <div class="queue-actions">
          <a href="{{ url('/patient/queue-detail') }}" class="btn btn-primary" style="text-decoration:none;text-align:center;">👁 Queue Details</a>
        </div>
      </div>
    @endif

    <div style="text-align:center;margin-top:60px;">
      <h3>Need another consultation?</h3>
      <p style="color:var(--text-gray);margin-bottom:24px;">You can make a new reservation for a different clinic.</p>
      <a href="{{ url('/patient/booking') }}" class="btn btn-primary">⊕ Book New Appointment</a>
    </div>
  </main>

  <footer class="footer">
    <div class="container footer-content">
      <span>© 2026 MedCampus Patient Portal. All rights reserved.</span>
    </div>
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>