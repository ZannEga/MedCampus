<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Medical Entry - MedCampus</title>
  <style>
.notif-panel {
  position:absolute; right:0; top:calc(100% + 8px); width:320px;
  background:var(--white); border:1px solid var(--border); border-radius:12px;
  box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200;
  display:none; overflow:hidden;
}
.notif-panel.open { display:block; }
.notif-header { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
.notif-header h4 { font-size:14px; font-weight:700; }
.notif-header span { font-size:11px; color:var(--primary-green); font-weight:600; cursor:pointer; }
.notif-item { padding:14px 18px; border-bottom:1px solid var(--border); cursor:pointer; transition:.15s; display:flex; gap:12px; }
.notif-item:hover { background:var(--bg-gray); }
.notif-item:last-child { border-bottom:none; }
.notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:5px; }
.notif-item h5 { font-size:13px; margin-bottom:3px; }
.notif-item p  { font-size:11px; color:var(--text-gray); }
.bell-wrapper  { position:relative; }
</style>
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
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
        <a href="{{ url('/doctor/patients') }}" class="active">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}">Schedule</a>
      </div>
      
      <div class="nav-profile" style="position: relative; display: flex; align-items: center; gap: 16px;">
        <div class="bell-wrapper"><div class="icon-btn">🔔</div></div>
        
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>

        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left;">
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Profile</a>
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="main-content container" style="max-width:900px;">
    <div class="flex-between" style="margin-bottom:32px;">
      <div>
        <h1 style="font-size:28px;margin-bottom:8px;">
          New Medical Entry — <span style="color:var(--primary-green);">{{ $appointment->patient_name ?? 'Patient' }}</span>
        </h1>
        <p style="color:var(--text-gray);font-size:13px;display:flex;gap:16px;">
          <span>Queue: <strong>{{ $appointment->queue_number ?? '—' }}</strong></span>
          <span>
            @if(isset($appointment))
               {{ $appointment->gender == 'M' ? 'Male' : 'Female' }}, {{ $appointment->date_of_birth ? \Carbon\Carbon::parse($appointment->date_of_birth)->age : 0 }} yrs • Consultation
            @else
               —
            @endif
          </span>
          <span>📅 Today, {{ now()->format('M d, Y') }}</span>
        </p>
      </div>
      
      <div style="display:flex;gap:12px;">
        <a href="{{ url('/doctor/patients') }}" class="btn btn-outline" id="btnCancelEntry">← Back</a>
      </div>
    </div>

    <div class="card" style="padding:40px;">
      <form id="newEntryForm" action="{{ url('/doctor/store-entry') }}" method="POST">
        @csrf
        
        <input type="hidden" name="appointment_id" value="{{ $appointmentId }}">

        <div class="form-section">
          <h2 class="form-section-title"><span style="color:var(--primary-green);">📈</span> 1. Patient Vitals</h2>
          <div class="grid-3">
            <div class="form-group">
              <label class="form-label">Blood Pressure (mmHg)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="blood_pressure" placeholder="e.g. 120/80">
                <span class="suffix-text">mmHg</span>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Heart Rate (bpm)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="heart_rate" placeholder="e.g. 72">
                <span class="suffix-text">bpm</span>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Temperature (°C)</label>
              <div class="input-with-suffix">
                <input type="text" class="form-input" name="temperature" placeholder="e.g. 36.6">
                <span class="suffix-text">°C</span>
              </div>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h2 class="form-section-title"><span style="color:var(--primary-green);">🩺</span> 2. Diagnosis &amp; Symptoms</h2>
          <div class="form-group">
            <label class="form-label">Presenting Symptoms</label>
            <textarea class="form-textarea" name="symptoms" placeholder="Describe symptoms reported by patient…"></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Primary Diagnosis <span style="color:#ef4444;">*</span></label>
            <input type="text" class="form-input" name="diagnosis" placeholder="Enter ICD-10 or clinical diagnosis" required>
          </div>
        </div>

        <div class="form-section">
          <div class="flex-between" style="margin-bottom:20px;">
            <h2 class="form-section-title" style="margin-bottom:0;"><span style="color:var(--primary-green);">💊</span> 3. Prescription</h2>
            <span style="color:var(--primary-green);font-size:13px;font-weight:600;cursor:pointer;" data-action="add-med">⊕ Add Medication</span>
          </div>
          <div style="display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:8px;font-size:11px;font-weight:700;color:var(--text-gray);text-transform:uppercase;">
            <span>Medication Name</span><span>Dosage</span><span>Frequency</span><span></span>
          </div>
          <div id="prescriptionRows">
            <div class="prescription-row" style="display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:16px;align-items:center;">
              <select name="medicines[]" class="form-input" style="width:100%;">
                <option value="">-- Select Medication --</option>
                @foreach($medicines as $med)
                  <option value="{{ $med->id_med }}">{{ $med->med_name }} (Stock: {{ $med->stock }})</option>
                @endforeach
              </select>
              <input type="text" name="dosages[]" class="form-input" placeholder="e.g. 500mg">
              <input type="text" name="frequencies[]" class="form-input" placeholder="e.g. Once daily">
              <div></div>
            </div>
          </div>
        </div>

        <div class="form-section" style="margin-bottom:0;">
          <h2 class="form-section-title"><span style="color:var(--primary-green);">📝</span> 4. Clinical Notes</h2>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Detailed Observations</label>
            <textarea class="form-textarea" name="notes" placeholder="Enter detailed findings, recommendations, or patient history updates…" style="min-height:150px;"></textarea>
          </div>
        </div>

        <div style="border-top:1px solid var(--border);margin-top:40px;padding-top:32px;display:flex;justify-content:flex-end;gap:16px;align-items:center;">
          <span style="color:var(--text-gray);font-size:14px;cursor:pointer;margin-right:auto;" data-action="discard">Discard Draft</span>
          <button type="submit" class="btn btn-primary" id="btnSubmitForm">Finalize &amp; Submit Entry</button>
        </div>
      </form>
    </div>
  </main>

  <footer style="text-align:center;padding:24px 0 40px;color:var(--text-gray);font-size:12px;">
    © 2026 MedCampus Portal. HIPAA Compliant Environment.
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/doctor.js') }}"></script>
  
  <script>
    // 🌟 PERBAIKAN 2: Gunakan json_encode agar anti-crash kalau ada nama obat yang aneh
    const rawMeds = {!! json_encode($medicines) !!};
    const DB_MEDICINES = rawMeds.map(m => ({
        id: m.id_med,
        name: m.med_name,
        stock: m.stock
    }));

    const entryOrigin = sessionStorage.getItem('mc_entry_origin') || '{{ url('/doctor/patients') }}';
    const backBtn = document.getElementById('btnCancelEntry');
    if (backBtn) backBtn.href = entryOrigin;

    document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));
    const originLink = document.querySelector(`.nav-links a[href="${entryOrigin}"]`);
    if (originLink) originLink.classList.add('active');

    // Script Tambah Baris Obat
    document.querySelector('[data-action="add-med"]').addEventListener('click', () => {
      const row = document.createElement('div');
      row.className = 'prescription-row';
      row.style.cssText = 'display:grid;grid-template-columns:2fr 1fr 2fr 40px;gap:16px;margin-bottom:16px;align-items:center;';
      
      let optionsHtml = '<option value="">-- Select Medication --</option>';
      DB_MEDICINES.forEach(m => {
        optionsHtml += `<option value="${m.id}">${m.name} (Stock: ${m.stock})</option>`;
      });

      row.innerHTML = `
        <select name="medicines[]" class="form-input" style="width:100%;">${optionsHtml}</select>
        <input type="text" name="dosages[]" class="form-input" placeholder="e.g. 5ml">
        <input type="text" name="frequencies[]" class="form-input" placeholder="e.g. Once daily">
        <button type="button" class="icon-btn delete-row" style="color:#ef4444;border:none;background:#fee2e2;">🗑</button>`;
      
      row.querySelector('.delete-row').addEventListener('click', () => row.remove());
      document.getElementById('prescriptionRows').appendChild(row);
    });

    // Script Discard
    document.querySelector('[data-action="discard"]').addEventListener('click', () => {
      if (confirm('Are you sure you want to discard this medical entry?')) {
          window.location.href = entryOrigin;
      }
    });

    // Animasi Loading Submit (Mencegah Double Click)
    document.getElementById('newEntryForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitForm');
        btn.textContent = 'Saving Record...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
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
</body>
</html>