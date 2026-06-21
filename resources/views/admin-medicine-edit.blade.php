<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Medicine - MedCampus Admin</title>
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-logo"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg> MedCampus</div>
    <nav class="sidebar-nav">
      <a href="{{ url('/admin/dashboard') }}"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Dashboard</a>
      <a href="{{ url('/admin/inventory') }}" class="active"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> Inventory</a>
      <a href="{{ url('/admin/users') }}"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Users</a>
      <a href="{{ url('/admin/schedules') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedules</a>
    </nav>
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; Inventory &rsaquo; <span>Edit Medicine</span></div>
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
      <form action="{{ url('/admin/medicine/update/' . $medicine->id_med) }}" method="POST">
        @csrf

        <div class="page-header">
          <div>
            <h1>Edit Medicine</h1>
            <p id="subtitle">Update stock records for <strong>{{ $medicine->med_name }}</strong></p>
          </div>
          <div style="display:flex;gap:12px;">
            <a href="{{ url('/admin/inventory') }}" class="btn btn-outline" style="display:flex;align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
              Discard
            </a>
            <button type="submit" class="btn btn-primary" style="display:flex;align-items:center;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
              Save Changes
            </button>
          </div>
        </div>

        <div class="admin-form-container">
          <h2 class="admin-form-title" style="display:flex;align-items:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            General Information
          </h2>
          <div class="admin-form-group">
            <label class="admin-form-label">Medicine Name <span style="color:#ef4444;">*</span></label>
            <input type="text" name="name" class="admin-form-input" value="{{ $medicine->med_name }}" required>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <div class="admin-form-group">
              <label class="admin-form-label">Category</label>
              <select name="category" class="admin-form-select" required>
                <option value="Antibiotics" {{ $medicine->med_category == 'Antibiotics' ? 'selected' : '' }}>Antibiotics</option>
                <option value="Analgesics" {{ $medicine->med_category == 'Analgesics' ? 'selected' : '' }}>Analgesics</option>
                <option value="Antidiabetics" {{ $medicine->med_category == 'Antidiabetics' ? 'selected' : '' }}>Antidiabetics</option>
                <option value="Vitamins" {{ $medicine->med_category == 'Vitamins' ? 'selected' : '' }}>Vitamins</option>
                <option value="Antihistamines" {{ $medicine->med_category == 'Antihistamines' ? 'selected' : '' }}>Antihistamines</option>
                <option value="Antacids" {{ $medicine->med_category == 'Antacids' ? 'selected' : '' }}>Antacids</option>
              </select>
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Medicine ID</label>
              <input type="text" class="admin-form-input" value="{{ $medicine->id_med }}" readonly style="color:var(--text-gray); background-color: var(--bg-gray);">
            </div>
          </div>
        </div>

        <div class="admin-form-container">
          <h2 class="admin-form-title" style="display:flex;align-items:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Inventory Logistics
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px;">
            <div class="admin-form-group">
              <label class="admin-form-label">Unit Type</label>
              <select name="unit" class="admin-form-select" required>
                <option value="Pills" {{ $medicine->med_unit == 'Pills' ? 'selected' : '' }}>Pills</option>
                <option value="Capsules" {{ $medicine->med_unit == 'Capsules' ? 'selected' : '' }}>Capsules</option>
                <option value="Bottles" {{ $medicine->med_unit == 'Bottles' ? 'selected' : '' }}>Bottles</option>
                <option value="Boxes" {{ $medicine->med_unit == 'Boxes' ? 'selected' : '' }}>Boxes</option>
                <option value="Vials" {{ $medicine->med_unit == 'Vials' ? 'selected' : '' }}>Vials</option>
              </select>
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Current Stock Level <span style="color:#ef4444;">*</span></label>
              <input type="number" id="edit-stock" name="stock" class="admin-form-input" min="0" value="{{ $medicine->stock }}" required style="border-color:var(--primary-green);">
            </div>
            <div class="admin-form-group">
              <label class="admin-form-label">Status (auto)</label>
              <input type="text" id="edit-status-display" class="admin-form-input" readonly style="color:var(--text-gray); background-color: var(--bg-gray);">
            </div>
          </div>

          <div style="display:flex;gap:12px;align-items:flex-start;padding:16px;border-radius:8px;background:#fffbeb;border:1px solid #fbd38d;margin-top:8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ea580c;flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div>
              <h4 style="font-size:14px;margin-bottom:4px;">Compliance Note</h4>
              <p style="font-size:13px;color:var(--text-gray);">Manual stock changes create an audit trail entry. Ensure physical counts have been reconciled before saving.</p>
            </div>
          </div>
        </div>
      </form>
    </main>
  </div>

  <script>
    function updateStatusDisplay() {
      const stockInput = document.getElementById('edit-stock');
      const statusDisplay = document.getElementById('edit-status-display');
      const n = parseInt(stockInput.value, 10) || 0;
      
      if (n <= 0) {
        statusDisplay.value = 'Out of Stock';
        statusDisplay.style.color = '#ef4444'; // Merah
      } else if (n < 20) {
        statusDisplay.value = 'Low Stock';
        statusDisplay.style.color = '#d97706'; // Kuning/Oranye
      } else {
        statusDisplay.value = 'In Stock';
        statusDisplay.style.color = '#059669'; // Hijau
      }
    }

    updateStatusDisplay();
    document.getElementById('edit-stock').addEventListener('input', updateStatusDisplay);
  </script>
</body>
</html>