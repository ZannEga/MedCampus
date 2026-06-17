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
    <div class="sidebar-logo">MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
      <a href="{{ url('/admin/inventory') }}">Inventory</a>
      <a href="{{ url('/admin/users') }}" class="active">Users</a>
      <a href="{{ url('/admin/schedules') }}">Schedules</a>
    </nav>
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
            <a href="{{ url('/admin/users') }}" class="btn btn-outline">← Cancel</a>
            <button type="submit" class="btn btn-primary">💾 Save Changes</button>
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
            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:24px;">👤 Personal Information</h2>

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

            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:24px;padding-top:24px;border-top:1px solid var(--border);">🏥 Organisational Details</h2>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:32px;">
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Role</label>
                <select name="role" class="admin-form-select">
                  <option value="Doctor"  {{ $user->id_role == 2 ? 'selected' : '' }}>Doctor</option>
                  <option value="Student" {{ $user->id_role == 1 ? 'selected' : '' }}>Student</option>
                  <option value="Admin"   {{ $user->id_role == 3 ? 'selected' : '' }}>Admin</option>
                </select>
              </div>
              <div class="admin-form-group" style="margin-bottom:0;">
                <label class="admin-form-label">Department / Poli</label>
                <select name="department" class="admin-form-select">
                  <option value="General Medicine" {{ $user->user_dept == 'General Medicine' ? 'selected' : '' }}>General Medicine</option>
                  <option value="Dental Clinic" {{ $user->user_dept == 'Dental Clinic' ? 'selected' : '' }}>Dental Clinic</option>
                  <option value="Pharmacy" {{ $user->user_dept == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                  <option value="None (Student / Admin)" {{ $user->user_dept == 'None (Student / Admin)' ? 'selected' : '' }}>None (Student / Admin)</option>
                </select>
              </div>
            </div>

            <h2 class="admin-form-title" style="text-transform:uppercase;font-size:13px;letter-spacing:1px;margin-bottom:16px;padding-top:24px;border-top:1px solid var(--border);">🔒 Account Status</h2>
            
            <input type="hidden" name="status" id="inputStatus" value="{{ $user->user_status }}">

            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:32px;">
              <div class="status-option {{ $user->user_status == 'active' ? 'selected' : '' }}" data-status="active">✅ ACTIVE</div>
              <div class="status-option {{ $user->user_status == 'offline' ? 'selected' : '' }}" data-status="offline">🔘 OFFLINE</div>
              <div class="status-option {{ $user->user_status == 'suspended' ? 'selected' : '' }}" data-status="suspended">🚫 SUSPENDED</div>
              <div class="status-option {{ $user->user_status == 'on-leave' ? 'selected' : '' }}" data-status="on-leave">🏖 ON LEAVE</div>
            </div>

            <div class="flex-between" style="border-top:1px solid var(--border);padding-top:20px;">
              <span style="font-size:12px;color:var(--text-gray);">Terakhir diubah: {{ $user->updated_at }}</span>
              <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            </div>

          </div>
        </div>
      </form>
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
    const editRoleInput = document.getElementById('edit-role'); // Pastikan ID di <select> role kamu adalah 'edit-role'
    const editDeptInput = document.getElementById('edit-department'); // Pastikan ID di <select> dept kamu adalah 'edit-department'

    function toggleEditDepartment() {
        if (!editRoleInput || !editDeptInput) return;

        if (editRoleInput.value === 'Doctor') {
            // JIKA DOKTER: Buka gembok dan warnai putih
            editDeptInput.disabled = false;
            editDeptInput.style.backgroundColor = '#ffffff'; 
            editDeptInput.style.cursor = 'pointer';
        } else {
            // JIKA BUKAN DOKTER: Gembok, kosongkan, dan warnai abu-abu kusam
            editDeptInput.value = '';       
            editDeptInput.disabled = true;  
            editDeptInput.style.backgroundColor = 'var(--bg-gray, #f8fafc)'; 
            editDeptInput.style.cursor = 'not-allowed';
        }
    }

    // Jalankan sekali saat halaman dimuat untuk menyesuaikan dengan data lama
    toggleEditDepartment();

    // Jalankan setiap kali Admin mengganti pilihan Role
    editRoleInput.addEventListener('change', toggleEditDepartment);
  </script>
</body>
</html>