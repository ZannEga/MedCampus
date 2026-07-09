<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - MedCampus</title>
  <style>
    #tab-security .login-activity-item { align-items: flex-start; }
    #tab-security .login-activity-icon { margin-top: 2px; flex-shrink: 0; }
    #tab-security .login-activity-info { display: flex; flex-direction: column; gap: 2px; }
    #tab-security .login-activity-info h5 { margin-bottom: 0; }
    #tab-security .login-activity-info p { margin: 0; }
    #tab-security .active-now { display: block; margin-top: 2px; }
    #tab-security .login-activity-list { gap: 12px; }
    #tab-security .security-form-card > p { margin-bottom: 20px; }
    #tab-security .form-grid-2 { margin-top: 16px; }
    .notif-panel { position:absolute; right:0; top:calc(100% + 8px); width:320px; background:var(--white); border:1px solid var(--border); border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200; display:none; overflow:hidden; text-align:left; }
    .notif-panel.open { display:block; }
    .notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .notif-header h4 { font-size:14px; font-weight:700; margin:0; color:var(--dark-navy); }
    .notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
    .notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
    .notif-item:hover { background:var(--bg-gray); }
    .notif-item:last-child { border-bottom:none; }
    .notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
    .notif-item h5 { font-size:13px; margin-bottom:3px; margin-top:0; color:var(--dark-navy); }
    .notif-item p  { font-size:11px; color:var(--text-gray); margin:0; }
  </style>
  <style>
    #tab-edit-profile .input-icon-wrap {
      display: flex;
      align-items: center;
      position: relative;
    }
    #tab-edit-profile .input-icon-wrap svg {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      width: 15px;
      height: 15px;
      stroke: var(--text-gray);
      fill: none;
      stroke-width: 2;
      pointer-events: none;
      flex-shrink: 0;
    }
    #tab-edit-profile .input-icon-wrap input {
      width: 100%;
      padding-left: 34px;
    }
    #tab-edit-profile .form-grid-2 {
      align-items: start;
    }
    #tab-edit-profile .form-grid-2 .form-field {
      min-width: 0;
    }
  </style>
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">

<script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
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
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;margin-right:12px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
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
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: var(--white); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: var(--bg-gray);">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            My Profile
          </a>
          
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Logout
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

  <main class="main-content">
    <div class="profile-page-wrap">

      <aside class="profile-sidebar">
        <button class="profile-sidebar-item active" data-tab="edit-profile">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          Edit Profile
        </button>
        <button class="profile-sidebar-item" data-tab="security">
          <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          Security
        </button>
        <button class="profile-sidebar-item" data-tab="preferences">
          <svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
          Preferences
        </button>
      </aside>

      <div class="profile-content">

        <div id="tab-edit-profile" class="tab-panel">
          <form action="{{ url('/patient/profile/update') }}" method="POST">
            @csrf
            
            <div class="profile-section">
              <h3>
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Personal Information
              </h3>
              <div class="form-grid-2">
                <div class="form-field">
                  <label>First Name</label>
                  <input type="text" name="first_name" value="{{ explode(' ', Auth::user()->user_name)[0] ?? '' }}" required>
                </div>
                <div class="form-field">
                  <label>Last Name</label>
                  <input type="text" name="last_name" value="{{ trim(strstr(Auth::user()->user_name, ' ')) ?? '' }}" required>
                </div>
              </div>
              <div class="form-grid-2">
                <div class="form-field">
                  <label>University ID (NIM)</label>
                  <input type="text" readonly value="{{ Auth::user()->id_user }}" style="color:var(--text-gray);background:var(--bg-gray);">
                </div>
                <div class="form-field">
                  <label>Date of Birth</label>
                  <input type="date" name="date_of_birth" value="{{ $profile->date_of_birth ?? '' }}" required>
                </div>
              </div>
              <div class="form-field">
                <label>Gender</label>
                <select name="gender" required>
                  <option value="">Select gender</option>
                  <option value="M" {{ ($profile->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
                  <option value="F" {{ ($profile->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
                </select>
              </div>
            </div>

            <div class="profile-section">
              <h3>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                Contact Information
              </h3>
              <div class="form-grid-2">
                <div class="form-field">
                  <label>University Email</label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="email" readonly value="{{ Auth::user()->user_email }}" style="color:var(--text-gray);background:var(--bg-gray);">
                  </div>
                </div>
                <div class="form-field">
                  <label>Phone Number</label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <input type="tel" name="phone_number" value="{{ Auth::user()->user_phone ?? '' }}">
                  </div>
                </div>
              </div>

              <div class="form-actions" style="margin-top: 24px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
          </form>
        </div>

        <div id="tab-security" class="tab-panel" style="display:none;">

          <div class="security-form-card">
            <h3>
              <svg viewBox="0 0 24 24"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
              Change Password
            </h3>
            <p>Ensure your account is using a long, random password to stay secure.</p>
            <div class="form-field">
              <label for="secCurrentPw">Current Password</label>
              <input type="password" id="secCurrentPw" placeholder="Enter current password">
            </div>
            <div class="form-grid-2">
              <div class="form-field">
                <label for="secNewPw">New Password</label>
                <input type="password" id="secNewPw" placeholder="Enter new password">
              </div>
              <div class="form-field">
                <label for="secConfirmPw">Confirm New Password</label>
                <input type="password" id="secConfirmPw" placeholder="Confirm new password">
              </div>
            </div>
            <div class="form-actions" style="margin-top:24px;">
              <button type="button" class="btn btn-outline" id="btnCancelPw">Cancel</button>
              <button type="button" class="btn btn-primary" id="btnUpdatePw">Update Password</button>
            </div>
          </div>

          <div class="security-form-card">
            <h3>
              <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
              Login Activity
            </h3>
            <p>Recent devices that have logged into your account.</p>
            <div class="login-activity-list">
              <div class="login-activity-item" style="display:flex; align-items:flex-start; gap:12px; margin-bottom:16px;">
                <div class="login-activity-icon" style="margin-top:2px;">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                </div>
                <div class="login-activity-info">
                  <h5 style="margin:0 0 4px 0; font-size:14px; color:var(--dark-navy);">Current Session • Web Browser</h5>
                  <p style="margin:0 0 4px 0; font-size:12px; color:var(--text-gray);">Surabaya, Indonesia (IP: {{ request()->ip() }})</p>
                  <span class="active-now" style="display:inline-block; font-size:11px; font-weight:700; color:var(--primary-green); background:var(--light-green); padding:2px 8px; border-radius:4px;">Active Now</span>
                </div>
              </div>
            </div>
            <div style="text-align:center;margin-top:14px;">
              <button type="button" class="btn btn-outline" id="btnSignOutAll" style="color:#ef4444;border-color:#fecaca;">
                Sign out of all devices
              </button>
            </div>
          </div>
        </div>

        <div id="tab-preferences" class="tab-panel" style="display:none;">
          <div class="pref-section" style="margin-bottom: 32px;">
            <h3>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" style="margin-right:8px; color:var(--primary-green);"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
              Notification Settings
            </h3>
            <p style="font-size:13px;color:var(--text-gray);margin-bottom:16px;">Manage how we contact you for appointments and clinical updates.</p>
            
            <div style="display:flex; flex-direction:column; gap:16px;">
              <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:16px; border-bottom:1px solid var(--border);">
                <div>
                  <h4 style="font-size:14px; margin-bottom:4px; color:var(--dark-navy);">Email Notifications</h4>
                  <p style="font-size:12px; color:var(--text-gray); margin:0;">Receive appointment reminders and health tips via email.</p>
                </div>
                <label class="toggle-switch"><input type="checkbox" id="toggleEmail" checked><span class="toggle-slider"></span></label>
              </div>
              
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                  <h4 style="font-size:14px; margin-bottom:4px; color:var(--dark-navy);">SMS Notifications</h4>
                  <p style="font-size:12px; color:var(--text-gray); margin:0;">Receive urgent alerts and queue updates via SMS.</p>
                </div>
                <label class="toggle-switch"><input type="checkbox" id="toggleSms"><span class="toggle-slider"></span></label>
              </div>
            </div>
          </div>
        
          <div class="pref-section">
            <h3>
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
              System Appearance
            </h3>
            <p style="font-size:13px;color:var(--text-gray);margin-bottom:14px;">Interface Theme</p>
            <div class="theme-cards">
              <div class="theme-card" data-theme="light" id="themeLightCard">
                <div class="theme-icon" style="display:flex;align-items:center;justify-content:center;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#f59e0b;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </div>
                <h4>Light Mode</h4>
              </div>
              <div class="theme-card" data-theme="dark" id="themeDarkCard">
                <div class="theme-icon" style="display:flex;align-items:center;justify-content:center;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#6366f1;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </div>
                <h4>Dark Mode</h4>
              </div>
            </div>
          </div>

          <div style="background:var(--white);border-radius:14px;border:1px solid var(--border);padding:20px 24px;display:flex;justify-content:space-between;align-items:center;">
            <div>
              <h4 style="font-size:14px;font-weight:700;margin-bottom:4px;">Apply Changes</h4>
              <p style="font-size:12px;color:var(--text-gray);">Review your preferences before saving.</p>
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn btn-outline" id="btnDiscardPrefs" style="color:var(--primary-green);border-color:var(--primary-green);">Discard</button>
              <button type="button" class="btn btn-primary" id="btnSavePrefs">Save Changes</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="footer">
    <div class="container footer-content">
      <span>© 2026 MedCampus Patient Portal. All rights reserved.</span>
    </div>
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <!-- <script src="{{ asset('js/profile-dropdown.js') }}"></script> -->
  <script src="{{ asset('js/patient.js') }}"></script>
  <script>
    const session  = AppData.getSession();
    
    let user = {
        name: "{!! $profile->user_name ?? '' !!}",
        email: "{!! $profile->user_email ?? '' !!}",
        idNumber: "{!! $profile->nim_nip ?? '' !!}",
        phone: "{!! $profile->user_phone ?? '' !!}",
        dob: "{!! $profile->date_of_birth ?? '' !!}",
        gender: "{!! $profile->gender == 'L' ? 'male' : ($profile->gender == 'P' ? 'female' : '') !!}"
    };

    function defaultAvatar(size) {
      const init = (user.name || 'U').split(' ').filter(Boolean).map(w=>w[0].toUpperCase()).slice(0,2).join('');
      return `https://placehold.co/${size || 72}x${size || 72}/fca5a5/ffffff?text=${init}`;
    }

    function populate() {
      const name  = session?.name  || user.name  || '';
      const email = session?.email || user.email || '';
      const parts = name.trim().split(' ');
      const first = parts[0] || '';
      const last  = parts.slice(1).join(' ') || '';
      const avatar = user.avatar || defaultAvatar();

      document.getElementById('editAvatarPreview').src = avatar;
      document.getElementById('editFirstName').value   = first;
      document.getElementById('editLastName').value    = last;
      document.getElementById('editStudentId').value   = user.idNumber || '—';
      document.getElementById('editEmail').value       = email;
      document.getElementById('editPhone').value       = (user.phone && user.phone !== '—') ? user.phone : '';
      document.getElementById('editEcName').value      = user.ecName  || '';
      document.getElementById('editEcPhone').value     = user.ecPhone || '';
      if (user.dob)    document.getElementById('editDob').value    = user.dob;
      if (user.gender) document.getElementById('editGender').value = user.gender;
    }

    const tabBtns   = document.querySelectorAll('.profile-sidebar-item[data-tab]');
    const tabPanels = document.querySelectorAll('.tab-panel');

    function switchTab(tabId) {
      tabBtns.forEach(b => b.classList.toggle('active', b.dataset.tab === tabId));
      tabPanels.forEach(p => { p.style.display = p.id === 'tab-' + tabId ? '' : 'none'; });
    }

    tabBtns.forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

    const urlTab = new URLSearchParams(location.search).get('tab');
    if (urlTab) switchTab(urlTab);

    document.getElementById('btnUpdatePw').addEventListener('click', () => {
      const cur  = document.getElementById('secCurrentPw').value;
      const nw   = document.getElementById('secNewPw').value;
      const conf = document.getElementById('secConfirmPw').value;
      if (!cur)           { if(typeof Toast !== 'undefined') Toast.show('Enter your current password.', 'error'); else alert('Enter current password'); return; }
      if (nw.length < 6)  { if(typeof Toast !== 'undefined') Toast.show('New password must be at least 6 characters.', 'error'); else alert('Password too short'); return; }
      if (nw !== conf)    { if(typeof Toast !== 'undefined') Toast.show('Passwords do not match.', 'error'); else alert('Passwords do not match'); return; }

      ['secCurrentPw','secNewPw','secConfirmPw'].forEach(id => document.getElementById(id).value = '');
      if(typeof Toast !== 'undefined') Toast.show('Password updated successfully!', 'success'); else alert('Password updated successfully!');
    });

    document.getElementById('btnCancelPw').addEventListener('click', () => {
      ['secCurrentPw','secNewPw','secConfirmPw'].forEach(id => document.getElementById(id).value = '');
    });

    document.getElementById('btnSignOutAll').addEventListener('click', () => {
      if (!confirm('Sign out from all devices? You will be logged out here too.')) return;
      if(typeof Toast !== 'undefined') Toast.show('Signed out from all devices.', 'info'); else alert('Signed out');
      setTimeout(() => { window.location.href = '{{ url('/logout') }}'; }, 1000);
    });

    (function restorePrefs() {
      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      document.getElementById('themeLightCard').classList.toggle('selected', !isDark);
      document.getElementById('themeDarkCard').classList.toggle('selected',   isDark);
      if (isDark) {
          document.documentElement.classList.add('dark-mode');
          document.body.classList.add('dark-mode');
      }

      const savedEmail = localStorage.getItem('mc_notif_email');
      const savedSms   = localStorage.getItem('mc_notif_sms');
      if (savedEmail !== null && document.getElementById('toggleEmail')) document.getElementById('toggleEmail').checked = savedEmail === '1';
      if (savedSms   !== null && document.getElementById('toggleSms')) document.getElementById('toggleSms').checked   = savedSms   === '1';
    })();

    document.querySelectorAll('.theme-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');

        const isDark = card.dataset.theme === 'dark';
        document.documentElement.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('dark-mode', isDark);
      });
    });

    document.getElementById('btnSavePrefs').addEventListener('click', () => {
      const dark = document.querySelector('.theme-card.selected')?.dataset.theme === 'dark';

      document.documentElement.classList.toggle('dark-mode', dark);
      document.body.classList.toggle('dark-mode', dark);

      localStorage.setItem('mc_dark_mode', dark ? '1' : '0');
      
      if(document.getElementById('toggleEmail')) localStorage.setItem('mc_notif_email', document.getElementById('toggleEmail').checked ? '1' : '0');
      if(document.getElementById('toggleSms')) localStorage.setItem('mc_notif_sms', document.getElementById('toggleSms').checked ? '1' : '0');

      if(typeof Toast !== 'undefined') Toast.show('Preferences saved successfully!', 'success'); else alert('Saved!');
    });

    document.getElementById('btnDiscardPrefs').addEventListener('click', () => {
      if (!confirm('Discard unsaved preference changes?')) return;

      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      document.getElementById('themeLightCard').classList.toggle('selected', !isDark);
      document.getElementById('themeDarkCard').classList.toggle('selected',   isDark);

      document.documentElement.classList.toggle('dark-mode', isDark);
      document.body.classList.toggle('dark-mode', isDark);

      const lang = localStorage.getItem('mc_pref_lang');
      const tz   = localStorage.getItem('mc_pref_tz');
      if (lang) document.getElementById('prefLang').value     = lang;
      if (tz)   document.getElementById('prefTimezone').value = tz;
      const savedEmail = localStorage.getItem('mc_notif_email');
      const savedSms   = localStorage.getItem('mc_notif_sms');
      if (savedEmail !== null) document.getElementById('toggleEmail').checked = savedEmail === '1';
      if (savedSms   !== null) document.getElementById('toggleSms').checked   = savedSms   === '1';
      if(typeof Toast !== 'undefined') Toast.show('Changes discarded.', 'info'); else alert('Discarded.');
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
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
            { color:'#10b981', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#059669;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> No New Alerts</span>', body: 'You are all caught up with your medical updates!' }
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