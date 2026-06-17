<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Schedule - MedCampus Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg> MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}" class="active"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; Schedules &rsaquo; <span>Add New</span></div>
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
    </header>

    <main class="content-area" style="max-width:900px;">
      <div class="page-header" style="margin-bottom:32px;">
        <div><h1>Create Daily Roster</h1><p>Assign medical staff to clinics and shifts for optimal patient care flow.</p></div>
      </div>

      <form action="{{ url('/admin/schedules/store') }}" method="POST" class="admin-form-container">
        @csrf
        <h2 class="admin-form-title"><span style="color:var(--primary-green);">📋</span> Schedule Specifications</h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Medical Practitioner <span style="color:#ef4444;">*</span></label>
            <select name="doctor_id" id="add-doctor" class="admin-form-select" required>
              <option value="" disabled selected>Select a Doctor</option>
              @foreach($doctors as $doc)
                <option value="{{ $doc->id_user }}">{{ $doc->user_name }} ({{ $doc->user_dept }})</option>
              @endforeach
            </select>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Clinical Department <span style="color:#ef4444;">*</span></label>
            <select name="department" id="add-dept" class="admin-form-select">
              <option value="General Medicine">General Medicine</option>
              <option value="Cardiology">Cardiology</option>
              <option value="Neurology">Neurology</option>
              <option value="Pediatrics">Pediatrics</option>
              <option value="Dental Unit">Dental Unit</option>
            </select>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Schedule Date <span style="color:#ef4444;">*</span></label>
            <input type="date" name="date" id="add-date" class="admin-form-input" required>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Room Assignment <span style="color:#ef4444;">*</span></label>
            <input type="text" name="room" id="add-room" class="admin-form-input" placeholder="e.g. Consultation Room 402" required>
          </div>
        </div>

        <div class="admin-form-group" style="margin-top:8px;">
          <label class="admin-form-label">Designated Work Shift</label>
          
          <input type="hidden" name="shift" id="shift-input" value="Morning">

          <div class="grid-3">
            <div class="shift-card active" data-shift="Morning" data-time="08:00 – 14:00">
              <div class="shift-icon">🌅</div>
              <div class="shift-title">Morning</div>
              <div class="shift-time">08:00 – 14:00</div>
            </div>
            <div class="shift-card" data-shift="Afternoon" data-time="14:00 – 20:00">
              <div class="shift-icon" style="color:#ea580c;">☀️</div>
              <div class="shift-title">Afternoon</div>
              <div class="shift-time">14:00 – 20:00</div>
            </div>
            <div class="shift-card" data-shift="Evening" data-time="20:00 – 02:00">
              <div class="shift-icon" style="color:#3b82f6;">🌙</div>
              <div class="shift-title">Evening</div>
              <div class="shift-time">20:00 – 02:00</div>
            </div>
          </div>
        </div>

        <h2 class="admin-form-title" style="margin-top:32px;"><span style="color:var(--text-gray);">📝</span> Clinical Notes</h2>
        <div class="admin-form-group">
          <textarea name="notes" id="add-notes" class="admin-form-input" placeholder="Enter specific instructions or patient focus for this shift…" style="min-height:120px;resize:vertical;"></textarea>
        </div>

        <div style="border-top:1px solid var(--border);margin-top:24px;padding-top:24px;display:flex;justify-content:flex-end;gap:12px;">
          <a href="{{ url('/admin/schedules') }}" class="btn btn-outline">Cancel</a>
          <button type="submit" id="btnAdd" class="btn btn-primary">💾 Add Schedule</button>
        </div>
      </form>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script>
    // Atur tanggal awal ke hari ini
    document.getElementById('add-date').value = new Date().toISOString().slice(0,10);

    // Animasi kartu shift & update nilai hidden input
    const shiftInput = document.getElementById('shift-input');
    document.querySelectorAll('.shift-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.shift-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        // Isi input tersembunyi dengan nama shift yang diklik
        shiftInput.value = card.dataset.shift;
      });
    });
  </script>
</body>
</html>