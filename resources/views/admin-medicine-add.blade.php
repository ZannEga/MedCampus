<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Medicine - MedCampus Admin</title>
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
    <div class="sidebar-footer"><a href="{{ url('/admin/settings') }}"><svg width="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Settings</a></div>
  </aside>

  <div class="main-wrapper">
    <header class="topbar">
      <div class="breadcrumb">Admin &rsaquo; Inventory &rsaquo; <span>New Medicine</span></div>
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
    </header>

    <main class="content-area" style="max-width:900px;">
      <div class="page-header" style="margin-bottom:40px;">
        <div><h1>New Medicine Entry</h1><p>Record a new pharmaceutical product into the central inventory.</p></div>
      </div>

      <form action="{{ route('medicine.store') }}" method="POST" class="admin-form-container">
        @csrf

        <div style="background:var(--bg-gray);border-radius:12px;padding:20px;margin-bottom:32px;display:flex;align-items:center;gap:16px;border:1px solid var(--border);">
          <div id="preview-icon" style="width:48px;height:48px;background:var(--light-green);color:var(--primary-green);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path></svg>
          </div>
          <div style="flex:1;">
            <h3 id="preview-name" style="font-size:17px;margin-bottom:4px;color:var(--dark-navy);">New Medicine</h3>
            <p id="preview-sub" style="font-size:13px;color:var(--text-gray);">Fill in the form below</p>
          </div>
          <span id="preview-badge" class="badge badge-active">In Stock</span>
        </div>

        <h2 class="admin-form-title" style="display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          Basic Information
        </h2>
        <div class="admin-form-group">
          <label class="admin-form-label">Medicine Name <span style="color:#ef4444;">*</span></label>
          <input type="text" id="add-name" name="name" class="admin-form-input" placeholder="e.g., Amoxicillin 500mg" required>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Category <span style="color:#ef4444;">*</span></label>
            <select id="add-category" name="category" class="admin-form-select" required>
              <option value="" disabled selected>Select Category</option>
              <option value="Antibiotics">Antibiotics</option>
              <option value="Analgesics">Analgesics</option>
              <option value="Antidiabetics">Antidiabetics</option>
              <option value="Vitamins">Vitamins</option>
              <option value="Antihistamines">Antihistamines</option>
              <option value="Antacids">Antacids</option>
            </select>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">SKU / Serial Number</label>
            <input type="text" id="add-sku" name="sku" class="admin-form-input" readonly style="color:var(--text-gray);">
            <p style="font-size:10px;color:var(--text-gray);margin-top:4px;">Auto-generated from name and category.</p>
          </div>
        </div>

        <h2 class="admin-form-title" style="margin-top:24px;padding-top:24px;border-top:1px solid var(--border);display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
          Logistics &amp; Stock
        </h2>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px;">
          <div class="admin-form-group">
            <label class="admin-form-label">Unit Type</label>
            <select id="add-unit" name="unit" class="admin-form-select">
              <option value="Pills">Pills</option>
              <option value="Capsules">Capsules</option>
              <option value="Bottles">Bottles</option>
              <option value="Boxes">Boxes</option>
              <option value="Vials">Vials</option>
            </select>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Initial Stock <span style="color:#ef4444;">*</span></label>
            <input type="number" id="add-stock" name="stock" class="admin-form-input" value="0" min="0" required>
          </div>
          <div class="admin-form-group">
            <label class="admin-form-label">Status (auto)</label>
            <input type="text" id="add-status-display" name="status" class="admin-form-input" readonly style="color:var(--text-gray);" value="Out of Stock">
          </div>
        </div>

        <h2 class="admin-form-title" style="margin-top:24px;padding-top:24px;border-top:1px solid var(--border);display:flex;align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--primary-green);margin-right:8px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          Additional Details
        </h2>
        <div class="admin-form-group" style="margin-bottom:0;">
          <label class="admin-form-label">Description / Notes</label>
          <textarea id="add-desc" name="description" class="admin-form-input" placeholder="Storage requirements, usage warnings, clinical notes…" style="min-height:100px;resize:vertical;"></textarea>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:24px;margin-top:32px;display:flex;justify-content:flex-end;gap:16px;align-items:center;">
          <a href="{{ url('/admin/inventory') }}" style="font-size:14px;font-weight:600;color:var(--text-gray);">Cancel</a>
          
          <button type="submit" class="btn btn-primary" style="display:flex;align-items:center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            Save Medicine
          </button>
        </div>
      </form>
    </main>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/admin.js') }}"></script>
  <script>
    // Auto SKU generation
    function genSku(name, cat) {
      const prefix = (name.split(' ')[0].slice(0,3) + (cat.slice(0,3) || 'MED')).toUpperCase();
      return prefix + '-' + Date.now().toString().slice(-4);
    }

    // Auto status from stock
    function stockToStatus(n) {
      if (n <= 0) return { label:'Out of Stock', status:'out_of_stock', color:'red' };
      if (n < 20)  return { label:'Low Stock',    status:'low_stock',   color:'orange' };
      return              { label:'In Stock',     status:'in_stock',    color:'green' };
    }

    const BADGE_CLS = { in_stock:'badge-active', low_stock:'badge-warning', out_of_stock:'badge-suspended' };

    function updatePreview() {
      const name  = document.getElementById('add-name').value.trim();
      const cat   = document.getElementById('add-category').value;
      const stock = parseInt(document.getElementById('add-stock').value, 10) || 0;
      const s     = stockToStatus(stock);

      // SKU
      if (name && cat) document.getElementById('add-sku').value = genSku(name, cat);

      // Status display
      document.getElementById('add-status-display').value = s.label;

      // Preview card
      document.getElementById('preview-name').textContent = name || 'New Medicine';
      document.getElementById('preview-sub').textContent  = cat
        ? `${cat} • ${document.getElementById('add-unit').value} • ${stock} units`
        : 'Fill in the form below';

      const badge = document.getElementById('preview-badge');
      badge.textContent = s.label;
      badge.className   = 'badge ' + BADGE_CLS[s.status];
    }

    ['add-name','add-category','add-unit','add-stock'].forEach(id => {
      const el = document.getElementById(id);
      el.addEventListener(el.tagName === 'SELECT' ? 'change' : 'input', updatePreview);
    });
    updatePreview();
  </script>
</body>
</html>
