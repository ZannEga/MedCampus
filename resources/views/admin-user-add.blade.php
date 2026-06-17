<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User - MedCampus Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo">
      <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
      MedCampus
    </div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}" class="active"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer">
      <a href="{{ url('/admin/settings') }}">
        <svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
    </div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; Users &rsaquo; <span>New User</span></div>
      <div class="topbar-right">
        <div class="admin-profile">
          <div class="admin-info">
            <h4>{{ Auth::user()->user_name }}</h4>
            <p>Super Admin</p>
          </div>
          <div class="admin-avatar">
            <img src="https://placehold.co/40x40/94a3b8/fff?text={{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}" alt="Avatar" style="width:100%;">
          </div>
          <a href="{{ url('/logout') }}" title="Keluar" style="background:none;border:1px solid #fecaca;color:#ef4444;font-size:12px;font-weight:600;padding:5px 10px;border-radius:6px;cursor:pointer;margin-left:8px;text-decoration:none;">↩</a>
        </div>
      </div>
    </header>

    <main class="content-area" style="max-width:900px;">
      <div class="page-header" style="margin-bottom:40px;">
        <div>
          <h1>Create New User</h1>
          <p>Register a new member to the MedCampus ecosystem. Ensure all credentials are accurate.</p>
        </div>
      </div>

      <div class="admin-form-container">
        <form action="{{ route('user.store') }}" method="POST">
          @csrf

          <div style="background:var(--bg-gray);border-radius:12px;padding:20px;margin-bottom:32px;display:flex;align-items:center;gap:20px;border:1px solid var(--border);">
            <div id="preview-avatar" style="width:56px;height:56px;border-radius:50%;background:var(--light-green);display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:var(--primary-green);flex-shrink:0;">?</div>
            <div>
              <h3 id="preview-name" style="font-size:18px;margin-bottom:4px;color:var(--dark-navy);">New User</h3>
              <p id="preview-sub" style="font-size:13px;color:var(--text-gray);">Fill in the form below</p>
            </div>
            <span id="preview-badge" class="badge badge-active" style="margin-left:auto;">Active</span>
          </div>

          <h2 class="admin-form-title">👤 Personal Information</h2>
          <div class="admin-form-group">
            <label class="admin-form-label">Full Name <span style="color:#ef4444;">*</span></label>
            <input type="text" id="add-name" name="name" class="admin-form-input" placeholder="e.g. Dr. Julian Harrison" value="{{ old('name') }}" required>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <div class="admin-form-group">
              <label class="admin-form-label">Email Address <span style="color:#ef4444;">*</span></label>
              <input type="email" id="add-email" name="email" class="admin-form-input" placeholder="j.harrison@medcampus.edu" value="{{ old('email') }}" required>
              @error('email')
                  <small style="color:#ef4444; font-size:12px; font-weight:600; display:block; margin-top:6px;">
                      {{ $message }}
                  </small>
              @enderror
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Phone Number</label>
              <input type="text" id="add-phone" name="phone" class="admin-form-input" placeholder="+62 812 0000 0000" value="{{ old('phone') }}">
            </div>
          </div>

          <h2 class="admin-form-title" style="margin-top:24px;padding-top:24px;border-top:1px solid var(--border);">
            🏥 Organisational Details
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <div class="admin-form-group">
              <label class="admin-form-label">System Role <span style="color:#ef4444;">*</span></label>
              <select id="add-role" name="role" class="admin-form-select">
                <option value="Student" selected>Student</option>
                <option value="Doctor">Doctor</option>
                <option value="Admin">Admin</option>
              </select>
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Department / Poli</label>
              <select id="add-department" name="department" class="admin-form-select">
                <option value="None (Student / Admin)">None (Student / Admin)</option>
                <option value="General Medicine">General Medicine</option>
                <option value="Dental Clinic">Dental Clinic</option>
                <option value="Pharmacy">Pharmacy</option>
              </select>
            </div>
          </div>

          <h2 class="admin-form-title" style="margin-top:24px;padding-top:24px;border-top:1px solid var(--border);">
            🔐 Account Setup
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <div class="admin-form-group">
              <label class="admin-form-label">Temporary Password <span style="color:#ef4444;">*</span></label>
              <input type="password" id="add-password" name="password" class="admin-form-input" placeholder="Set a temporary password" required>
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Confirm Password <span style="color:#ef4444;">*</span></label>
              <input type="password" id="add-confirm-password" name="password_confirmation" class="admin-form-input" placeholder="Konfirmasi kata sandi" required>
              <small id="password-error-message" style="color:#ef4444; font-size:12px; font-weight:600; display:none; margin-top:6px;">
                Kata sandi dan konfirmasi kata sandi tidak cocok. Mohon periksa kembali.
              </small>
            </div>
          </div>
          <p style="font-size:12px;color:var(--text-gray);margin-top:-12px;margin-bottom:24px;">
            ℹ The user will be asked to change this password on first login.
          </p>

          <div style="border-top:1px solid var(--border);padding-top:24px;display:flex;justify-content:flex-end;gap:16px;align-items:center;">
            <a href="{{ url('/admin/users') }}" style="font-size:14px;font-weight:600;color:var(--text-gray);">Cancel</a>
            <button type="submit" class="btn btn-primary">➕ Create User</button>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script>
    function updatePreview() {
      const name = document.getElementById('add-name').value.trim();
      const email = document.getElementById('add-email').value.trim();
      const roleElement = document.getElementById('add-role');
      const role = roleElement.options[roleElement.selectedIndex].text;
      const dept = document.getElementById('add-department').value;

      const initials = name
        ? name.split(' ').filter(Boolean).map(w => w[0].toUpperCase()).slice(0,2).join('')
        : '?';

      document.getElementById('preview-avatar').textContent  = initials;
      document.getElementById('preview-name').textContent    = name || 'Pengguna Baru';
      document.getElementById('preview-sub').textContent     = email
        ? (dept ? `${role} • ${dept}` : `${role}`)
        : 'Mohon lengkapi formulir di bawah ini';
    }

    ['add-name','add-email','add-role','add-department'].forEach(id => {
      document.getElementById(id).addEventListener('input', updatePreview);
      document.getElementById(id).addEventListener('change', updatePreview);
    });

    const formAddUser = document.querySelector('form');
    const errorMessage = document.getElementById('password-error-message');
    const inputConfirmPassword = document.getElementById('add-confirm-password');
    
    formAddUser.addEventListener('submit', function(event) {
      const pass1 = document.getElementById('add-password').value;
      const pass2 = inputConfirmPassword.value;

      if (pass1 !== pass2) {
        event.preventDefault();
        errorMessage.style.display = 'block';
        inputConfirmPassword.style.borderColor = '#ef4444';
        inputConfirmPassword.focus();
      }
    });

    inputConfirmPassword.addEventListener('input', function() {
        errorMessage.style.display = 'none';
        inputConfirmPassword.style.borderColor = 'var(--border)';
    });
    
    const roleInput = document.getElementById('add-role');
    const deptInput = document.getElementById('add-department');

    function toggleDepartment() {
        if (!roleInput || !deptInput) return;

        if (roleInput.value === 'Doctor') {
            // JIKA DOKTER: Buka gembok dan warnai putih
            deptInput.disabled = false;
            deptInput.style.backgroundColor = '#ffffff'; 
            deptInput.style.cursor = 'pointer';
        } else {
            // JIKA BUKAN DOKTER: Gembok, kosongkan, dan warnai abu-abu kusam
            deptInput.value = '';       
            deptInput.disabled = true;  
            deptInput.style.backgroundColor = 'var(--bg-gray, #f8fafc)'; 
            deptInput.style.cursor = 'not-allowed';
        }
        updatePreview(); // Tetap update tampilan kartu
    }

    // Jalankan sekali saat halaman load buat mastiin statusnya sesuai pilihan awal
    toggleDepartment();

    // Pasang pendeteksi perubahan
    roleInput.addEventListener('change', toggleDepartment);
  </script>
</body>
</html>