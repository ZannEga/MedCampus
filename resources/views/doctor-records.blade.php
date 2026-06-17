<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Records - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
  <style>
    .notif-panel { position:absolute; right:0; top:calc(100% + 8px); width:320px; background:var(--white); border:1px solid var(--border); border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:200; display:none; overflow:hidden; }
    .bell-wrapper { position:relative; }
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
        <div class="search-bar">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" placeholder="Search records by patient or diagnosis…" id="recordSearch">
        </div>
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}">Dashboard</a>
        <a href="{{ url('/doctor/patients') }}">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}" class="active">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}">Schedule</a>
      </div>
      <div class="nav-profile" style="position: relative; display: flex; align-items: center; gap: 16px;">
        
        <div class="bell-wrapper">
          <div class="icon-btn">🔔</div>
        </div>
        
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>

        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left;">
          
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            My Profile
          </a>
          
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Logout
          </a>
          
        </div>
      </div>
    </div>
  </nav>

  <main class="main-content container">
    <div class="flex-between" style="margin-bottom:32px;">
      <div>
        <h1 style="font-size:32px;margin-bottom:8px;">Medical Records</h1>
        <p style="color:var(--text-gray);font-size:14px;">Centralized database of university clinical check-ups and history.</p>
      </div>
      <a href="{{ url('/doctor/patients') }}" class="btn btn-primary">➕ Start Exam from Queue</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;margin-bottom:40px;">
      <div class="table-container">
        <table>
          <thead>
            <tr><th>Date</th><th>Record ID</th><th>Patient</th><th>Diagnosis / Notes</th><th>Attending Doctor</th><th>Actions</th></tr>
          </thead>
          <tbody id="recordsTbody"></tbody>
        </table>
      </div>
      <div class="flex-between" style="padding:16px 24px;border-top:1px solid var(--border);font-size:13px;color:var(--text-gray);">
        <span>Showing <strong id="showing-count">0</strong> records</span>
        <div style="display:flex;gap:8px;" id="paginationBtns"></div>
      </div>
    </div>
  </main>

  <div id="detailModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,22,35,0.6);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:0.2s;">
    <div style="background:#fff;width:100%;max-width:550px;border-radius:16px;padding:32px;box-shadow:0 20px 40px rgba(0,0,0,0.15);transform:translateY(16px);transition:0.2s;" id="modalCard">
      <div class="flex-between" style="margin-bottom:24px;border-bottom:1px solid var(--border);padding-bottom:16px;">
        <div>
          <h3 style="font-size:20px;margin-bottom:4px;" id="m-patient">Patient Name</h3>
          <p style="font-size:12px;color:var(--text-gray);" id="m-id">Record ID: -</p>
        </div>
        <button style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-gray);" onclick="closeModal()">✕</button>
      </div>
      
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;background:var(--bg-gray);padding:16px;border-radius:12px;">
        <div><label style="font-size:11px;color:var(--text-gray);font-weight:700;display:block;margin-bottom:4px;">DATE OF VISIT</label><span style="font-size:13px;font-weight:600;" id="m-date">-</span></div>
        <div><label style="font-size:11px;color:var(--text-gray);font-weight:700;display:block;margin-bottom:4px;">DOCTOR IN CHARGE</label><span style="font-size:13px;font-weight:600;" id="m-doctor">-</span></div>
      </div>

      <div style="margin-bottom:20px;">
        <label style="font-size:11px;color:var(--text-gray);font-weight:700;display:block;margin-bottom:8px;">PRESCRIBED MEDICATION</label>
        <ul id="m-meds" style="margin:0;padding-left:24px;font-size:14px;color:var(--primary-green);font-weight:600;"></ul>
      </div>

      <div style="margin-bottom:20px;">
        <label style="font-size:11px;color:var(--text-gray);font-weight:700;display:block;margin-bottom:8px;">DIAGNOSIS / CLINICAL NOTES</label>
        <p style="font-size:14px;line-height:1.6;color:var(--dark-navy);background:#f8fafc;padding:16px;border-radius:8px;border:1px solid var(--border);white-space:pre-wrap;" id="m-notes">-</p>
      </div>
      <div style="text-align:right;"><button class="btn btn-outline" onclick="closeModal()">Close Details</button></div>
    </div>
  </div>

  <script>
    // Menyedot Data Obat dari Laravel ke Javascript
    const REAL_RECORDS = [
        @foreach($records as $r)
        {
            id: "{{ $r->id_record }}",
            date: "{{ \Carbon\Carbon::parse($r->check_up_date)->format('d M Y') }}",
            patient: "{{ $r->patient_name }}",
            doctor: "{{ $r->doctor_name }}",
            notes: {!! json_encode($r->notes ?? 'No clinical notes recorded.') !!},
            meds: [
                @if(isset($r->prescriptions))
                    @foreach($r->prescriptions as $med)
                        "{{ $med->med_name }} ({{ $med->dosage }})",
                    @endforeach
                @endif
            ]
        },
        @endforeach
    ];

    const PAGE_SIZE = 6;
    let currentPage = 1;
    let filteredRecords = REAL_RECORDS;

    function renderRecords(list, page) {
      const tbody = document.getElementById('recordsTbody');
      tbody.innerHTML = '';
      
      if(list.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-gray);">No medical records found.</td></tr>';
        document.getElementById('showing-count').textContent = '0';
        document.getElementById('paginationBtns').innerHTML = '';
        return;
      }

      const start = (page - 1) * PAGE_SIZE;
      const paginated = list.slice(start, start + PAGE_SIZE);

      paginated.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td style="font-weight:500;">${r.date}</td>
          <td style="font-family:monospace;color:var(--text-gray); font-size:12px;">${r.id}</td>
          <td style="font-weight:600;color:var(--dark-navy);">${r.patient}</td>
          <td style="max-width:250px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-gray);font-size:13px;">${r.notes}</td>
          <td>Doc. ${r.doctor}</td>
          <td><button class="btn btn-outline" onclick="openModal('${r.id}')">View Details</button></td>`;
        tbody.appendChild(tr);
      });

      document.getElementById('showing-count').textContent = list.length;
      renderPagination(list.length, page);
    }

    function renderPagination(totalItems, page) {
      const totalPages = Math.ceil(totalItems / PAGE_SIZE);
      const btns = document.getElementById('paginationBtns');
      btns.innerHTML = '';

      if (totalPages <= 1) return;

      const makeBtn = (label, targetPage, disabled) => {
        const b = document.createElement('button');
        b.className = 'icon-btn';
        b.style.cssText = `border-radius:4px;padding:4px 10px;border:1px solid var(--border);cursor:pointer;background:${targetPage === currentPage ? 'var(--primary-green)' : 'transparent'};color:${targetPage === currentPage ? 'white' : 'var(--text-gray)'};`;
        b.textContent = label;
        b.disabled = disabled;
        if(disabled) b.style.opacity = '0.5';
        b.addEventListener('click', () => { if(!disabled) { currentPage = targetPage; renderRecords(filteredRecords, targetPage); } });
        btns.appendChild(b);
      };

      makeBtn('<', page - 1, page <= 1);
      for (let i = 1; i <= totalPages; i++) makeBtn(i, i, false);
      makeBtn('>', page + 1, page >= totalPages);
    }

    const modal = document.getElementById('detailModal');
    const card = document.getElementById('modalCard');

    function openModal(id) {
      const rec = REAL_RECORDS.find(r => r.id === id);
      if(!rec) return;

      document.getElementById('m-patient').textContent = rec.patient;
      document.getElementById('m-id').textContent = `Record ID: ${rec.id}`;
      document.getElementById('m-date').textContent = rec.date;
      document.getElementById('m-doctor').textContent = `Doc. ${rec.doctor}`;
      document.getElementById('m-notes').textContent = rec.notes;

      // Fitur Injeksi Data Obat ke Modal
      const medsContainer = document.getElementById('m-meds');
      medsContainer.innerHTML = '';
      if (rec.meds && rec.meds.length > 0) {
          rec.meds.forEach(m => {
              const li = document.createElement('li');
              li.textContent = m;
              li.style.marginBottom = '6px';
              medsContainer.appendChild(li);
          });
      } else {
          const li = document.createElement('li');
          li.textContent = 'No medications prescribed.';
          li.style.color = 'var(--text-gray)';
          li.style.listStyle = 'none';
          li.style.marginLeft = '-24px';
          li.style.fontWeight = 'normal';
          medsContainer.appendChild(li);
      }

      modal.style.opacity = '1'; modal.style.pointerEvents = 'auto';
      card.style.transform = 'translateY(0)';
    }

    function closeModal() {
      modal.style.opacity = '0'; modal.style.pointerEvents = 'none';
      card.style.transform = 'translateY(16px)';
    }

    document.getElementById('recordSearch').addEventListener('input', e => {
      const q = e.target.value.toLowerCase();
      filteredRecords = REAL_RECORDS.filter(r => r.patient.toLowerCase().includes(q) || r.notes.toLowerCase().includes(q) || r.id.toLowerCase().includes(q));
      currentPage = 1;
      renderRecords(filteredRecords, 1);
    });

    document.addEventListener('DOMContentLoaded', () => renderRecords(REAL_RECORDS, 1));
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