<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Schedule - MedCampus Admin</title>
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
    <div class="sidebar-footer">
      <a href="{{ url('/admin/settings') }}">
        <svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        Settings
      </a>
    </div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; Schedules &rsaquo; <span>Edit Schedule</span></div>
      <div class="topbar-right">
        <div class="admin-profile">
          <div class="admin-info">
            <h4>{{ Auth::user()->user_name }}</h4>
            <p>Super Admin</p>
          </div>
          <div class="admin-avatar">
            <img src="https://placehold.co/40x40/94a3b8/fff?text={{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}" alt="Avatar" style="width:100%;">
          </div>
          <a href="{{ url('/logout') }}" title="Keluar" style="background:#fef2f2;border:1px solid #fecaca;color:#ef4444;padding:6px;border-radius:6px;cursor:pointer;margin-left:8px;text-decoration:none;display:flex;align-items:center;transition:0.2s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          </a>
        </div>
      </div>
    </header>

    <main class="content-area" style="max-width:900px;">
      <div class="page-header" style="margin-bottom:32px;">
        <div><h1>Edit Schedule</h1><p>Update assigned shifts and clinical rooms for practitioners.</p></div>
      </div>

      <form action="{{ url('/admin/schedules/update/' . $schedule->id_schedule) }}" method="POST" class="admin-form-container">
        @csrf
        <h2 class="admin-form-title" style="display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          Schedule Specifications
        </h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Medical Practitioner <span style="color:#ef4444;">*</span></label>
            <select name="doctor_id" id="edit-doctor" class="admin-form-select" required>
              @foreach($doctors as $doc)
                <option value="{{ $doc->id_user }}" {{ $schedule->id_user == $doc->id_user ? 'selected' : '' }}>
                  {{ $doc->user_name }} ({{ $doc->user_dept }})
                </option>
              @endforeach
            </select>
          </div>
          
          <div class="admin-form-group">
            <label class="admin-form-label">Schedule ID (Read Only)</label>
            <input type="text" class="admin-form-input" value="{{ $schedule->id_schedule }}" readonly style="background-color: var(--bg-gray); color: var(--text-gray);">
          </div>

          <div class="admin-form-group">
            <label class="admin-form-label">Schedule Date <span style="color:#ef4444;">*</span></label>
            <input type="date" name="date" id="edit-date" class="admin-form-input" value="{{ $schedule->schedule_date }}" required>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Room Assignment <span style="color:#ef4444;">*</span></label>
            <input type="text" name="room" id="edit-room" class="admin-form-input" value="{{ $schedule->room }}" required>
          </div>
        </div>

        <div class="admin-form-group" style="margin-top:8px;">
          <label class="admin-form-label">Designated Work Shift</label>
          
          <input type="hidden" name="shift" id="shift-input" value="{{ $schedule->shift }}">

          <div class="grid-3">
            <div class="shift-card {{ $schedule->shift == 'Morning' ? 'active' : '' }}" data-shift="Morning">
              <div class="shift-icon" style="color:#f59e0b;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="M5 5l1.5 1.5"></path><path d="M17.5 17.5L19 19"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="M5 19l1.5-1.5"></path><path d="M17.5 6.5L19 5"></path></svg></div>
              <div class="shift-title">Morning</div>
              <div class="shift-time">08:00 – 14:00</div>
            </div>
            <div class="shift-card {{ $schedule->shift == 'Afternoon' ? 'active' : '' }}" data-shift="Afternoon">
              <div class="shift-icon" style="color:#ea580c;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg></div>
              <div class="shift-title">Afternoon</div>
              <div class="shift-time">14:00 – 20:00</div>
            </div>
            <div class="shift-card {{ $schedule->shift == 'Evening' ? 'active' : '' }}" data-shift="Evening">
              <div class="shift-icon" style="color:#3b82f6;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg></div>
              <div class="shift-title">Evening</div>
              <div class="shift-time">20:00 – 02:00</div>
            </div>
          </div>
        </div>

        <h2 class="admin-form-title" style="margin-top:32px;border-top:1px solid var(--border);padding-top:24px;display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);margin-right:8px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          Clinical Notes
        </h2>
        <div class="admin-form-group">
          <textarea name="notes" id="edit-notes" class="admin-form-input" style="min-height:120px;resize:vertical;">{{ $schedule->notes }}</textarea>
        </div>

        <div style="border-top:1px solid var(--border);margin-top:24px;padding-top:24px;display:flex;justify-content:flex-end;gap:12px;">
          <a href="{{ url('/admin/schedules') }}" class="btn btn-outline" style="display:flex;align-items:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Cancel
          </a>
          <button type="submit" class="btn btn-primary" style="display:flex;align-items:center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            Save Changes
          </button>
        </div>
      </form>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script>
    const shiftInput = document.getElementById('shift-input');
    document.querySelectorAll('.shift-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.shift-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        shiftInput.value = card.dataset.shift;
      });
    });
  </script>
</body>
</html>