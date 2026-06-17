<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service Guide - MedCampus</title>
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
        <a href="{{ url('/patient/dashboard') }}">Home</a>
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
  </nav>

  <main class="main-content container">
    <div class="service-hero">
      <h1>How to use MedCampus</h1>
      <p>Your health journey made simple. Follow these easy steps to manage your medical visits, from booking to viewing results.</p>
    </div>

    <div class="grid-3" style="margin-bottom:40px;">
      <div class="step-card">
        <div class="step-icon-wrapper">
          <div class="step-number">1</div>
          <div class="step-icon-box">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
        </div>
        <h3>Make a Reservation</h3>
        <p>Choose your preferred clinic and specialist doctor. Select a time slot that works best for your schedule.</p>
        <a href="{{ url('/patient/booking') }}" class="btn btn-primary" style="width:100%;">Book Now</a>
      </div>

      <div class="step-card">
        <div class="step-icon-wrapper">
          <div class="step-number">2</div>
          <div class="step-icon-box">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
        </div>
        <h3>Track Your Queue</h3>
        <p>Get your digital ticket instantly. Monitor your position in the live queue and arrive just in time.</p>
        <a href="{{ url('/patient/queue-detail') }}" class="btn btn-primary" style="width:100%;">Live Status</a>
      </div>

      <div class="step-card">
        <div class="step-icon-wrapper">
          <div class="step-number">3</div>
          <div class="step-icon-box">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
          </div>
        </div>
        <h3>View Results</h3>
        <p>Access your full medical history, lab results, and digital prescriptions securely in your profile after consultation.</p>
        <a href="{{ url('/patient/history') }}" class="btn btn-primary" style="width:100%;">My History</a>
      </div>
    </div>

    <div class="cta-section">
      <h2>Ready to get started?</h2>
      <p>Explore all the features MedCampus has to offer.</p>
      <a href="{{ url('/patient/dashboard') }}" class="btn btn-outline" style="border-color:var(--primary-green);color:var(--primary-green);background:white;">← Back to Home</a>
    </div>
  </main>

  <footer class="footer" style="background:transparent;border-top:none;">
    <div class="container footer-content" style="border-top:1px solid var(--border);padding-top:24px;">
      <span>© 2026 MedCampus Digital Health. All rights reserved.</span>
      <div style="display:flex;gap:24px;">
        <a href="javascript:void(0)" onclick="Toast.show('Privacy Policy is not available in the demo.', 'info')">Privacy Policy</a>
        <a href="javascript:void(0)" onclick="Toast.show('Terms of Service is not available in the demo.', 'info')">Terms of Service</a>
        <a href="javascript:void(0)" onclick="Toast.show('Contact Support is not available in the demo.', 'info')">Contact Support</a>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/profile-dropdown.js') }}"></script>
  <script src="{{ asset('js/patient.js') }}"></script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>
