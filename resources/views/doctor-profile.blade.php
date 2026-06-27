<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
  <style>
    .bell-wrapper { position:relative; }
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
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}">Dashboard</a>
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

        <div class="profile-view-card" id="profileViewCard">
          <div class="profile-view-head">
            <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 36px; margin: 0 auto 16px;">
              {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
            </div>
            <h2 id="viewName">{{ Auth::user()->user_name }}</h2>
            <p id="viewTitle">{{ Auth::user()->user_dept ?? 'General Medicine' }}</p>
            <span class="status-pill"><span class="status-dot-green"></span> Active Duty</span>
          </div>

          <div style="margin-bottom:20px;">
            <h4 style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-gray);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary-green)" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              Professional Information
            </h4>
            <div class="profile-info-grid">
              <div class="profile-info-item"><div class="label">Staff ID</div><div class="value">{{ Auth::user()->id_user }}</div></div>
              <div class="profile-info-item"><div class="label">Department</div><div class="value">{{ Auth::user()->user_dept ?? 'General Medicine' }}</div></div>
              <div class="profile-info-item"><div class="label">Clinic Room</div><div class="value">Poli Umum - R.101</div></div>
            </div>
          </div>

          <div style="border-top:1px solid var(--border);padding-top:20px;">
            <h4 style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-gray);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary-green)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Contact Details
            </h4>
            <div class="profile-info-grid">
              <div class="profile-info-item"><div class="label">Work Email</div><div class="value">{{ Auth::user()->user_email }}</div></div>
              <div class="profile-info-item"><div class="label">Phone Number</div><div class="value">{{ Auth::user()->user_phone ?? '—' }}</div></div>
            </div>
          </div>

          <div style="margin-top:24px;display:flex;gap:12px;">
            <button class="btn btn-primary" id="btnShowEditForm">Edit Profile</button>
            <button class="btn btn-outline" id="btnChangePasswordView">Change Password</button>
          </div>
        </div>

        <div id="editProfileForm" style="display:none;">
          <form action="{{ url('/doctor/profile/update') }}" method="POST">
            @csrf
            
            <div class="profile-section">
              <h3>
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Personal Information
              </h3>
              <div class="form-grid-2">
                <div class="form-field">
                  <label for="editFullName">Full Name</label>
                  <input type="text" id="editFullName" name="user_name" value="{{ Auth::user()->user_name }}" required>
                </div>
                <div class="form-field">
                  <label for="editDepartment">Department</label>
                  <select id="editDepartment" name="user_dept">
                    <option value="General Medicine" {{ Auth::user()->user_dept == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                    <option value="Dental Clinic" {{ Auth::user()->user_dept == 'Dental Clinic' ? 'selected' : '' }}>Dental Clinic</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="profile-section">
              <h3>
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                Contact Information
              </h3>
              <div class="form-grid-2">
                <div class="form-field">
                  <label for="editWorkEmail">Work Email</label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="email" id="editWorkEmail" name="user_email" value="{{ Auth::user()->user_email }}" required>
                  </div>
                </div>
                <div class="form-field">
                  <label for="editPhone">Phone Number</label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <input type="tel" id="editPhone" name="user_phone" value="{{ Auth::user()->user_phone ?? '' }}">
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <button type="button" class="btn btn-outline" id="btnCancelEdit">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnSaveProfile">Save Changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div id="tab-security" class="tab-panel" style="display:none;">
        <div class="security-form-card">
          <h3>
            <svg viewBox="0 0 24 24"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
            Change Password
          </h3>
          <p>Ensure your account is using a long, random password to stay secure.</p>

          @if(session('success'))
              <div style="background:#dcfce7; color:#16a34a; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px; font-weight:600;">
                  ✅ {{ session('success') }}
              </div>
          @endif
          @if(session('error'))
              <div style="background:#fee2e2; color:#dc2626; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px; font-weight:600;">
                  ❌ {{ session('error') }}
              </div>
          @endif

          <form id="passwordForm" action="{{ url('/doctor/profile/password') }}" method="POST">
            @csrf
            <div class="form-field">
              <label for="secCurrentPw">Current Password</label>
              <input type="password" id="secCurrentPw" name="current_password" required placeholder="Enter current password">
            </div>
            <div class="form-grid-2">
              <div class="form-field">
                <label for="secNewPw">New Password</label>
                <input type="password" id="secNewPw" name="new_password" required minlength="6" placeholder="Enter new password (min. 6 chars)">
              </div>
              <div class="form-field">
                <label for="secConfirmPw">Confirm New Password</label>
                <input type="password" id="secConfirmPw" required placeholder="Confirm new password">
              </div>
            </div>
            
            <p id="pwWarning" style="color:#ef4444; font-size:12px; font-weight:600; margin-top:-10px; margin-bottom:16px; display:none;">
               ⚠️ New password and confirmation do not match!
            </p>

            <p id="pwSameWarning" style="color:#ef4444; font-size:12px; font-weight:600; margin-top:-10px; margin-bottom:16px; display:none;">
               ⚠️ New password cannot be the same as current password!
            </p>

            <div class="form-actions">
              <button type="button" class="btn btn-outline" id="btnCancelPw">Cancel</button>
              <button type="submit" class="btn btn-primary" id="btnUpdatePw">Update Password</button>
            </div>
          </form>
        </div>
      </div> <div id="tab-preferences" class="tab-panel" style="display:none;">

        <div class="pref-section">
          <h3>
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9"></path></svg>
            General Preferences
          </h3>
          <div class="pref-select-row" style="margin-bottom:20px;">
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
          <p class="system-note">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            Schedules and patient records will align with this timezone.
          </p>
        </div>

        <div class="pref-section">
          <h3>
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            System Appearance
          </h3>
          <p style="font-size:13px;color:var(--text-gray);margin-bottom:16px;">Interface Theme</p>
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
          <p class="system-note" style="margin-top:14px;" id="themeNote">
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
              <p>Receive daily summaries, critical patient updates, and system alerts via email.</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" id="toggleEmail" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="notif-toggle-row">
            <div class="notif-toggle-info">
              <h5>SMS Notifications</h5>
              <p>Get immediate text messages for emergency codes and urgent scheduling changes.</p>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" id="toggleSms">
              <span class="toggle-slider"></span>
            </label>
          </div>
        </div>

        <div style="background:var(--white);border-radius:16px;border:1px solid var(--border);padding:24px 32px;display:flex;justify-content:space-between;align-items:center;">
          <div>
            <h4 style="font-size:15px;font-weight:700;margin-bottom:4px;">Apply Changes</h4>
            <p style="font-size:13px;color:var(--text-gray);">Review your preferences before saving to ensure your portal experience is optimal.</p>
          </div>
          <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;">
            <button type="button" class="btn btn-primary" id="btnSavePrefs" style="min-width:160px;">Save Changes</button>
            <button type="button" class="btn btn-outline" id="btnDiscardPrefs" style="min-width:160px;color:var(--primary-green);border-color:var(--primary-green);">Discard Edits</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  
  <script>
    // ── Tab switching ─────────────────────────────────────────────────────────
    const tabBtns   = document.querySelectorAll('.profile-sidebar-item[data-tab]');
    const tabPanels = document.querySelectorAll('.tab-panel');

    function switchTab(tabId) {
      tabBtns.forEach(b => b.classList.toggle('active', b.dataset.tab === tabId));
      tabPanels.forEach(p => { p.style.display = p.id === 'tab-' + tabId ? '' : 'none'; });
    }

    tabBtns.forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

    // ── Edit form show / hide ─────────────────────────────────────────────────
    document.getElementById('btnShowEditForm').addEventListener('click', () => {
      document.getElementById('profileViewCard').style.display  = 'none';
      document.getElementById('editProfileForm').style.display  = '';
    });

    document.getElementById('btnCancelEdit').addEventListener('click', () => {
      document.getElementById('editProfileForm').style.display  = 'none';
      document.getElementById('profileViewCard').style.display  = '';
    });

    // ── Change password shortcut from view card ───────────────────────────────
    document.getElementById('btnChangePasswordView').addEventListener('click', () => {
      switchTab('security');
      document.getElementById('secCurrentPw').focus();
    });

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
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const newPw = document.getElementById('secNewPw').value;
            const confirmPw = document.getElementById('secConfirmPw').value;
            const warning = document.getElementById('pwWarning');
            
            if (newPw !== confirmPw) {
                e.preventDefault();
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        });

        document.getElementById('secConfirmPw').addEventListener('input', function() {
             document.getElementById('pwWarning').style.display = 'none';
        });
        
        document.getElementById('btnCancelPw').addEventListener('click', function() {
             document.getElementById('passwordForm').reset();
             document.getElementById('pwWarning').style.display = 'none';
        });
    </script>

    <script>
        const pwForm = document.getElementById('passwordForm');
        const curPw = document.getElementById('secCurrentPw');
        const newPw = document.getElementById('secNewPw');
        const confirmPw = document.getElementById('secConfirmPw');
        const pwWarning = document.getElementById('pwWarning');
        const pwSameWarning = document.getElementById('pwSameWarning');
        const btnUpdate = document.getElementById('btnUpdatePw');

        function validatePassword() {
            let hasError = false;

            if (newPw.value.length > 0 && curPw.value.length > 0 && newPw.value === curPw.value) {
                pwSameWarning.style.display = 'block';
                hasError = true;
            } else {
                pwSameWarning.style.display = 'none';
            }

            if (confirmPw.value.length > 0) {
                if (newPw.value !== confirmPw.value) {
                    pwWarning.style.display = 'block';
                    hasError = true;
                } else {
                    pwWarning.style.display = 'none';
                }
            } else {
                pwWarning.style.display = 'none';
            }

            if (hasError) {
                btnUpdate.disabled = true;
                btnUpdate.style.opacity = '0.5';
                btnUpdate.style.cursor = 'not-allowed';
            } else {
                btnUpdate.disabled = false;
                btnUpdate.style.opacity = '1';
                btnUpdate.style.cursor = 'pointer';
            }
        }

        curPw.addEventListener('input', validatePassword);
        newPw.addEventListener('input', validatePassword);
        confirmPw.addEventListener('input', validatePassword);

        pwForm.addEventListener('submit', function(e) {
            if (newPw.value === curPw.value || newPw.value !== confirmPw.value) {
                e.preventDefault();
                validatePassword();
            } else {
                btnUpdate.innerHTML = 'Updating...';
                btnUpdate.style.opacity = '0.7';
            }
        });

        document.getElementById('btnCancelPw').addEventListener('click', function() {
             pwForm.reset();
             pwWarning.style.display = 'none';
             pwSameWarning.style.display = 'none';
             validatePassword();
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

    document.querySelectorAll('.theme-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.theme-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        
        const isDark = card.dataset.theme === 'dark';
        document.documentElement.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('dark-mode', isDark);
      });
    });

    // 2. FUNGSI LOAD DATA DARI MEMORI (LOCAL STORAGE)
    function loadPreferences() {
      const isDark = localStorage.getItem('mc_dark_mode') === '1';
      const lightCard = document.getElementById('themeLightCard');
      const darkCard = document.getElementById('themeDarkCard');
      
      if (lightCard && darkCard) {
          lightCard.classList.toggle('selected', !isDark);
          darkCard.classList.toggle('selected', isDark);
      }
      
      document.documentElement.classList.toggle('dark-mode', isDark);
      document.body.classList.toggle('dark-mode', isDark);

      const savedEmail = localStorage.getItem('mc_notif_email');
      const savedSms   = localStorage.getItem('mc_notif_sms');
      if (savedEmail !== null && document.getElementById('toggleEmail')) document.getElementById('toggleEmail').checked = savedEmail === '1';
      if (savedSms   !== null && document.getElementById('toggleSms')) document.getElementById('toggleSms').checked   = savedSms   === '1';
    }

    loadPreferences();

    const btnSavePrefs = document.getElementById('btnSavePrefs');
    if (btnSavePrefs) {
      btnSavePrefs.addEventListener('click', () => {
        const dark = document.querySelector('.theme-card.selected')?.dataset.theme === 'dark';
        
        localStorage.setItem('mc_dark_mode', dark ? '1' : '0');
        if(document.getElementById('toggleEmail')) localStorage.setItem('mc_notif_email', document.getElementById('toggleEmail').checked ? '1' : '0');
        if(document.getElementById('toggleSms')) localStorage.setItem('mc_notif_sms', document.getElementById('toggleSms').checked ? '1' : '0');
        
        alert('Preferences saved successfully!'); 
      });
    }

    const btnDiscardPrefs = document.getElementById('btnDiscardPrefs');
    if (btnDiscardPrefs) {
      btnDiscardPrefs.addEventListener('click', () => {
        if (!confirm('Discard unsaved preference changes?')) return;
        
        loadPreferences(); // Tarik lagi data dari memori browser
        alert('Changes discarded.');
      });
    }
  </script>
</body>
</html>