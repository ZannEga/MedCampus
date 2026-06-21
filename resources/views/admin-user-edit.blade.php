<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - MedCampus Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
      .status-option { cursor: pointer; padding: 10px; border: 1px solid var(--border); border-radius: 8px; text-align: center; font-size: 12px; font-weight: 600; color: var(--text-gray); transition: 0.2s; }
      .status-option.selected { border-color: var(--primary-green); background: var(--light-green); color: var(--primary-green); }
  </style>
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
      <div class="breadcrumb">Admin &rsaquo; Users &rsaquo; <span>Edit User</span></div>
    </header>

    <main class="content-area" style="max-width:1000px;">
      <form action="{{ url('/admin/users/update/'.$user->id_user) }}" method="POST">
        @csrf

        <div class="page-header" style="margin-bottom:40px;">
          <div>
            <h1>Edit User Profile: {{ $user->user_name }}</h1>
            <p>Update personal information and account permissions for this user.</p>
          </div>
          <div style="display:flex;gap:12px;">
            <a href="{{ url('/admin/users') }}" class="btn btn-outline" style="display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
              Cancel
            </a>
            <button type="submit" class="btn btn-primary" style="display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
              Save Changes
            </button>
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 2.5fr;gap:32px;">
          
          <div class="admin-form-container" style="text-align:center;height:fit-content;">
            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;justify-content:center;letter-spacing:1px;">Profile Picture</h2>
            <div style="position:relative;width:140px;height:140px;margin:24px auto;border-radius:50%;background:#cbd5e1;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:bold;color:white;">
              {{ strtoupper(substr($user->user_name, 0, 1)) }}
            </div>
            <p style="font-size:11px;color:var(--text-gray);">Fitur upload foto segera hadir.</p>
          </div>

          <div class="admin-form-container">
            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:24px;display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              Personal Information
            </h2>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Full Name</label>
                <input type="text" name="name" class="admin-form-input" value="{{ $user->user_name }}" required>
              </div>
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Email Address</label>
                <input type="email" name="email" class="admin-form-input" value="{{ $user->user_email }}" required>
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:32px;">
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Phone Number</label>
                <input type="text" name="phone" class="admin-form-input" value="{{ $user->user_phone }}">
              </div>
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">ID Number</label>
                <input type="text" class="admin-form-input" value="{{ $user->id_user }}" readonly style="color:var(--text-gray);">
              </div>
            </div>

            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:24px;padding-top:24px;border-top:1px solid var(--border);display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path><path d="M10 9h4"></path><path d="M12 7v4"></path></svg>
              Organisational Details
            </h2>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:32px;">
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Role</label>
                <select id="edit-role" name="role" class="admin-form-select">
                  <option value="Doctor"  {{ $user->id_role == 2 ? 'selected' : '' }}>Doctor</option>
                  <option value="Student" {{ $user->id_role == 1 ? 'selected' : '' }}>Student</option>
                  <option value="Admin"   {{ $user->id_role == 3 ? 'selected' : '' }}>Admin</option>
                </select>
              </div>
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Department / Poli</label>
                <select id="edit-department" name="department" class="admin-form-select">
                  <option value="General Medicine" {{ $user->user_dept == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                  <option value="Dental Clinic" {{ $user->user_dept == 'Dental Clinic' ? 'selected' : '' }}>Dental Clinic</option>
                  <option value="Pharmacy" {{ $user->user_dept == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                  <option value="None (Student / Admin)" {{ $user->user_dept == 'None (Student / Admin)' ? 'selected' : '' }}>None (Student / Admin)</option>
                </select>
              </div>
            </div>

            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:16px;padding-top:24px;border-top:1px solid var(--border);display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              Account Status
            </h2>
            
            <input type="hidden" name="status" id="inputStatus" value="{{ $user->user_status }}">

            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:32px;">
              <div class="status-option {{ $user->user_status == 'active' ? 'selected' : '' }}" data-status="active" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                ACTIVE
              </div>
              <div class="status-option {{ $user->user_status == 'offline' ? 'selected' : '' }}" data-status="offline" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle></svg>
                OFFLINE
              </div>
              <div class="status-option {{ $user->user_status == 'suspended' ? 'selected' : '' }}" data-status="suspended" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                SUSPENDED
              </div>
              <div class="status-option {{ $user->user_status == 'on-leave' ? 'selected' : '' }}" data-status="on-leave" style="display:flex;align-items:center;justify-content:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                ON LEAVE
              </div>
            </div>

            <div class="flex-between" style="border-top:1px solid var(--border);padding-top:20px;">
              <span style="font-size:12px;color:var(--text-gray);">Terakhir diubah: {{ $user->updated_at }}</span>
              <button type="submit" class="btn btn-primary" style="display:flex;align-items:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Save Changes
              </button>
            </div>

          </div>
        </div>
      </main>
  </div>

  <script>
    // Script ini cuma buat ngatur efek klik di kartu status
    document.querySelectorAll('.status-option').forEach(opt => {
      opt.addEventListener('click', function() {
        // Hapus warna hijau dari semua kartu
        document.querySelectorAll('.status-option').forEach(o => o.classList.remove('selected'));
        // Kasih warna hijau ke kartu yang diklik
        this.classList.add('selected');
        // Masukin value statusnya ke input tersembunyi biar ke-kirim ke Laravel
        document.getElementById('inputStatus').value = this.dataset.status;
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editRoleInput = document.getElementById('edit-role'); 
        const editDeptInput = document.getElementById('edit-department'); 

        function toggleEditDepartment() {
            if (!editRoleInput || !editDeptInput) return;

            if (editRoleInput.value === 'Doctor') {
                // JIKA DOKTER: Buka gembok dan warnai putih
                editDeptInput.disabled = false;
                editDeptInput.style.backgroundColor = '#ffffff'; 
                editDeptInput.style.cursor = 'pointer';
            } else {
                // JIKA STUDENT/ADMIN: Kunci gembok, ganti warna abu, dan paksa pilih 'None'
                editDeptInput.value = 'None (Student / Admin)'; 
                editDeptInput.disabled = true;  
                editDeptInput.style.backgroundColor = 'var(--bg-gray, #f8fafc)'; 
                editDeptInput.style.cursor = 'not-allowed';
            }
        }

        // 1. Jalankan saat halaman load untuk menyesuaikan status awal dari database
        toggleEditDepartment();

        // 2. Jalankan tiap kali ada perubahan di dropdown Role
        editRoleInput.addEventListener('change', toggleEditDepartment);
    });
  </script>
</body>
</html>