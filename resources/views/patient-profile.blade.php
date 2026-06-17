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

              <div class="form-actions" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Changes</button>
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
              <div class="login-activity-item">
                <div class="login-activity-icon">
                  <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                </div>
                <div class="login-activity-info">
                  <h5>Mac OS • Safari</h5>
                  <p style="margin-bottom:3px;">Surabaya, Indonesia</p>
                  <span class="active-now" style="display:block;">Active Now</span>
                </div>
              </div>
              <div class="login-activity-item">
                <div class="login-activity-icon">
                  <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                </div>
                <div class="login-activity-info">
                  <h5>iOS • App</h5>
                  <p style="margin-bottom:2px;">Surabaya, Indonesia</p>
                  <p style="color:var(--text-gray);">Yesterday at 09:15</p>
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

          <div class="pref-section">
            <h3>
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9"></path></svg>
              General Preferences
            </h3>
            <div class="pref-select-row" style="margin-bottom:16px;">
              <div class="form-field" style="margin-bottom:0;">
                <label for="prefLang">Language</label>
                <select id="prefLang">
                  <option value="en">English</option>
                  <option value="id">Bahasa Indonesia</option>
                </select>
              </div>
              <div class="form-field" style="margin-bottom:0;">
                <label for="prefTimezone">Timezone</label>
                <select id="prefTimezone">
                  <option value="wib">WIB (UTC+7)</option>
                  <option value="wita">WITA (UTC+8)</option>
                  <option value="wit">WIT (UTC+9)</option>
                </select>
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
                <div class="theme-icon">☀️</div>
                <h4>Light Mode</h4>
              </div>
              <div class="theme-card" data-theme="dark" id="themeDarkCard">
                <div class="theme-icon">🌙</div>
                <h4>Dark Mode</h4>
              </div>
            </div>
            <p class="system-note" style="margin-top:12px;">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
              System default is currently active.
            </p>
          </div>

          <div class="pref-section">
            <h3>
              <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
              Notification Settings
            </h3>
            <div class="notif-toggle-row">
              <div class="notif-toggle-info">
                <h5>Email Notifications</h5>
                <p>Receive appointment reminders and health updates via email.</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" id="toggleEmail" checked>
                <span class="toggle-slider"></span>
              </label>
            </div>
            <div class="notif-toggle-row">
              <div class="notif-toggle-info">
                <h5>SMS Notifications</h5>
                <p>Get text messages for urgent appointment updates and queue alerts.</p>
              </div>
              <label class="toggle-switch">
                <input type="checkbox" id="toggleSms">
                <span class="toggle-slider"></span>
              </label>
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

    populate();

    document.getElementById('avatarFileInput').addEventListener('change', function() {
      const file = this.files[0]; if (!file) return;
      if (file.size > 800 * 1024) { Toast.show('File exceeds 800K limit.', 'error'); this.value = ''; return; }
      const reader = new FileReader();
      reader.onload = e => { document.getElementById('editAvatarPreview').src = e.target.result; };
      reader.readAsDataURL(file);
    });

    document.getElementById('btnRemoveAvatar').addEventListener('click', () => {
      document.getElementById('editAvatarPreview').src = defaultAvatar();
      document.getElementById('avatarFileInput').value = '';
    });

    document.getElementById('btnCancelEdit').addEventListener('click', () => {
      populate();
      Toast.show('Changes discarded.', 'info');
    });

    document.getElementById('btnUpdatePw').addEventListener('click', () => {
      const cur  = document.getElementById('secCurrentPw').value;
      const nw   = document.getElementById('secNewPw').value;
      const conf = document.getElementById('secConfirmPw').value;
      if (!cur)           { Toast.show('Enter your current password.', 'error'); return; }
      if (nw.length < 6)  { Toast.show('New password must be at least 6 characters.', 'error'); return; }
      if (nw !== conf)    { Toast.show('Passwords do not match.', 'error'); return; }

      const creds   = JSON.parse(localStorage.getItem('mc_stored_creds') || '[]');
      const existing = creds.find(c => c.email === session?.email);
      if (existing) existing.password = nw;
      else creds.push({ email: session?.email, password: nw });
      localStorage.setItem('mc_stored_creds', JSON.stringify(creds));

      ['secCurrentPw','secNewPw','secConfirmPw'].forEach(id => document.getElementById(id).value = '');
      Toast.show('Password updated successfully!', 'success');
    });

    document.getElementById('btnCancelPw').addEventListener('click', () => {
      ['secCurrentPw','secNewPw','secConfirmPw'].forEach(id => document.getElementById(id).value = '');
    });

    document.getElementById('btnSignOutAll').addEventListener('click', () => {
      if (!confirm('Sign out from all devices? You will be logged out here too.')) return;
      AppData.logout();
      Toast.show('Signed out from all devices.', 'info');
      setTimeout(() => { window.location.href = '{{ url('/login') }}'; }, 1000);
    });

    (function restorePrefs() {
      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      document.getElementById('themeLightCard').classList.toggle('selected', !isDark);
      document.getElementById('themeDarkCard').classList.toggle('selected',   isDark);
      if (isDark) document.body.classList.add('dark-mode');

      const lang = localStorage.getItem('mc_pref_lang');
      const tz   = localStorage.getItem('mc_pref_tz');
      if (lang) document.getElementById('prefLang').value     = lang;
      if (tz)   document.getElementById('prefTimezone').value = tz;

      const savedEmail = localStorage.getItem('mc_notif_email');
      const savedSms   = localStorage.getItem('mc_notif_sms');
      if (savedEmail !== null) document.getElementById('toggleEmail').checked = savedEmail === '1';
      if (savedSms   !== null) document.getElementById('toggleSms').checked   = savedSms   === '1';
    })();

    document.querySelectorAll('.theme-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
      });
    });

    document.getElementById('btnSavePrefs').addEventListener('click', () => {
      const dark = document.querySelector('.theme-card.selected')?.dataset.theme === 'dark';
      document.body.classList.toggle('dark-mode', dark);
      localStorage.setItem('mc_dark_mode',   dark ? '1' : '0');
      localStorage.setItem('mc_notif_email', document.getElementById('toggleEmail').checked ? '1' : '0');
      localStorage.setItem('mc_notif_sms',   document.getElementById('toggleSms').checked   ? '1' : '0');
      localStorage.setItem('mc_pref_lang',   document.getElementById('prefLang').value);
      localStorage.setItem('mc_pref_tz',     document.getElementById('prefTimezone').value);
      Toast.show('Preferences saved successfully!', 'success');
    });

    document.getElementById('btnDiscardPrefs').addEventListener('click', () => {
      if (!confirm('Discard unsaved preference changes?')) return;
      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      document.getElementById('themeLightCard').classList.toggle('selected', !isDark);
      document.getElementById('themeDarkCard').classList.toggle('selected',   isDark);
      const lang = localStorage.getItem('mc_pref_lang');
      const tz   = localStorage.getItem('mc_pref_tz');
      if (lang) document.getElementById('prefLang').value     = lang;
      if (tz)   document.getElementById('prefTimezone').value = tz;
      const savedEmail = localStorage.getItem('mc_notif_email');
      const savedSms   = localStorage.getItem('mc_notif_sms');
      if (savedEmail !== null) document.getElementById('toggleEmail').checked = savedEmail === '1';
      if (savedSms   !== null) document.getElementById('toggleSms').checked   = savedSms   === '1';
      Toast.show('Changes discarded.', 'info');
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>