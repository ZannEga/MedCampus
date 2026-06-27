<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Appointment - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}">Home</a>
        <a href="{{ url('/patient/booking') }}" class="active">Book Appointment</a>
        <a href="{{ url('/patient/history') }}">Medical History</a>
      </div>
      <div class="nav-profile" style="position: relative;">
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;margin-right:12px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        </div>
        
        <!-- Tombol Profil Utama -->
        <div id="mcProfileToggle" onclick="toggleDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px; margin-left:16px; border: 1px solid var(--border);">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-right: 4px;">▼</span>
        </div>

        <!-- Menu Dropdown Pop-up -->
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: var(--white); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: var(--bg-gray);">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-gray);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            My Profile
          </a>
          
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);" onmouseover="this.style.background='var(--bg-gray)'" onmouseout="this.style.background='transparent'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Logout
          </a>
        </div>
      </div>

      <!-- Script Interaksi Dropdown -->
      <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('mcDropdownMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
        
        // Auto-close jika klik sembarang tempat di layar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mcDropdownMenu');
            const toggle = document.getElementById('mcProfileToggle');
            if (menu && !menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
      </script>
  </nav>

  <main class="main-content container">
    <h1 style="margin-bottom:8px;">Create New Appointment</h1>
    <p style="color:var(--text-gray);margin-bottom:40px;max-width:600px;">Complete your visit details below. We will help you find the best consultation schedule.</p>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:40px;">
      <!-- KIRI: FORM PILIHAN -->
      <div>
        <h3 style="margin-bottom:16px;">1. Select Clinic</h3>
        <div class="selection-grid" id="clinicGrid">
          <div class="select-card active" data-clinic="General Clinic">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            <h4>General Clinic</h4>
            <p>Consultation for general health complaints.</p>
          </div>
          <div class="select-card" data-clinic="Dental Clinic">
            <svg viewBox="0 0 24 24"><path d="M12 2c-3.31 0-6 2.69-6 6 0 3.31 6 14 6 14s6-10.69 6-14c0-3.31-2.69-6-6-6zm0 8.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            <h4>Dental Clinic</h4>
            <p>Dental health care and oral hygiene.</p>
          </div>
        </div>
        
        <h3 style="margin-bottom:16px; margin-top:32px;">2. Select Date</h3>
        <div class="card card-shadow" style="padding:20px;margin-bottom:32px;">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:center;">
            <div class="form-group" style="margin-bottom:0;">
              <label style="font-size:12px;font-weight:700;color:var(--text-gray);text-transform:uppercase;display:block;margin-bottom:8px;">Appointment Date</label>
              <input type="date" id="appointmentDate" style="width:100%;padding:12px 16px;border:1px solid var(--border);border-radius:8px;font-size:14px;font-family:var(--font-main);outline:none;transition:.2s;" min="">
            </div>
            <div id="dateHint" style="font-size:13px;color:var(--text-gray);padding:12px;background:var(--bg-gray);border-radius:8px;line-height:1.6;display:flex;align-items:flex-start;gap:8px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top:2px;flex-shrink:0;color:var(--primary-green);"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              <span>Select a date to see available doctors and time slots.</span>
            </div>
          </div>
        </div>

        <h3 style="margin-bottom:16px;">3. Select Doctor &amp; Time</h3>
        <div class="card card-shadow">
          
          <!-- 🌟 TAMPILAN DOKTER DARI DATABASE -->
          <div style="margin-bottom:20px;">
            <label style="font-size:12px;font-weight:700;color:var(--text-gray);text-transform:uppercase;display:block;margin-bottom:8px;">Select Doctor</label>
            <div id="doctorList" style="display:flex;flex-direction:column;gap:10px;">
              @forelse($doctors as $index => $doc)
                @php
                    $isFirst = $index === 0;
                    $borderColor = $isFirst ? 'var(--primary-green)' : 'var(--border)';
                    $bgClass = $isFirst ? 'var(--light-green)' : 'var(--white)';
                    $spec = $doc->department ?? 'General Practitioner';
                @endphp
                <div class="doc-card" data-doc-id="{{ $doc->id_user }}" data-doc-name="{{ $doc->user_name }}" data-spec="{{ $spec }}"
                     style="display:flex;justify-content:space-between;align-items:center;padding:14px 16px;border:1.5px solid {{ $borderColor }};border-radius:10px;cursor:pointer;transition:.2s;background:{{ $bgClass }};">
                  <div style="display:flex;gap:12px;align-items:center;">
                    <div style="width:40px;height:40px;border-radius:50%;background:var(--primary-green);color:white;display:flex;align-items:center;justify-content:center;font-weight:bold;">
                        {{ strtoupper(substr($doc->user_name, 0, 2)) }}
                    </div>
                    <div>
                      <h4 style="font-size:14px;margin-bottom:2px;">{{ $doc->user_name }}</h4>
                      <p style="font-size:12px;color:var(--text-gray);">{{ $spec }}</p>
                    </div>
                  </div>
                </div>
              @empty
                <p style="color:var(--text-gray);font-size:13px;padding:12px;">No doctors available right now.</p>
              @endforelse
            </div>
          </div>

          <div class="grid-3" id="slotGrid">
            <p style="grid-column: 1 / -1; font-size:13px; color:var(--text-gray); font-style:italic;">Loading available shifts...</p>
          </div>
        </div>
      </div>

      <!-- KANAN: SUMMARY (RINGKASAN) -->
      <div>
        <div class="card card-shadow" style="position:sticky;top:100px;">
          <h3 style="margin-bottom:24px;">Booking Summary</h3>
          <div style="margin-bottom:16px;border-bottom:1px dashed var(--border);padding-bottom:16px;">
            <p style="font-size:11px;color:var(--text-gray);font-weight:700;text-transform:uppercase;">Clinic</p>
            <p id="summary-clinic" style="font-weight:600;">General Clinic</p>
          </div>
          <div style="margin-bottom:16px;border-bottom:1px dashed var(--border);padding-bottom:16px;">
            <p style="font-size:11px;color:var(--text-gray);font-weight:700;text-transform:uppercase;">Doctor</p>
            <p id="summary-doctor" style="font-weight:600;">—</p>
          </div>
          <div style="margin-bottom:24px;">
            <p style="font-size:11px;color:var(--text-gray);font-weight:700;text-transform:uppercase;">Date &amp; Shift</p>
            <p id="summary-date" style="font-weight:600;">—</p>
            <p id="summary-slot" style="font-size:13px;color:var(--text-gray);">Morning WIB</p>
          </div>
          <div class="flex-between" style="margin-bottom:12px;font-size:14px;">
            <span style="color:var(--text-gray);">Consultation Fee</span><span>Rp 150.000</span>
          </div>
          <div class="flex-between" style="margin-bottom:24px;font-size:14px;">
            <span style="color:var(--text-gray);">Administrative Fee</span><span>Rp 15.000</span>
          </div>
          <div class="flex-between" style="margin-bottom:24px;font-size:18px;font-weight:700;">
            <span>Total</span><span style="color:var(--primary-green);">Rp 165.000</span>
          </div>
          <button class="btn btn-primary" id="btnConfirmPay" style="width:100%;">Proceed to Checkout →</button>
          <p style="text-align:center;font-size:11px;color:var(--text-gray);margin-top:16px;">By continuing, you agree to MedCampus terms &amp; conditions.</p>
        </div>
      </div>
    </div>

    <div id="alertModal" class="modal-overlay">
    <div class="modal-card" style="max-width: 360px; text-align: center; padding: 32px 24px;">
      <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      </div>
      <h2 style="font-size: 18px; color: var(--dark-navy); margin-bottom: 8px;">Action Required</h2>
      <p id="alertMessage" style="color: var(--text-gray); font-size: 14px; margin-bottom: 24px; line-height: 1.5;">
        Message goes here.
      </p>
      <button type="button" onclick="document.getElementById('alertModal').classList.remove('active')" class="btn btn-primary" style="width: 100%;">OK, I Understand</button>
    </div>
  </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script>
    let selectedClinic = 'General Clinic';
    let selectedSlot   = null;
    let selectedDoctorId = null;
    let selectedDoctorName = '';
    let selectedDoctorSpec = '';

    document.querySelectorAll('#clinicGrid .select-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('#clinicGrid .select-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        selectedClinic = card.dataset.clinic;
        document.getElementById('summary-clinic').textContent = selectedClinic;
      });
    });

    let selectedScheduleId = null;

    function fetchShifts() {
        const dateRaw = document.getElementById('appointmentDate').value;
        const slotGrid = document.getElementById('slotGrid');
        
        if (!selectedDoctorId || !dateRaw) return;

        slotGrid.innerHTML = '<div style="grid-column: 1 / -1; display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-gray); font-style:italic;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spin-animation"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="4.93" x2="19.07" y2="7.76"></line></svg> Generating time slots...</div>';
        selectedSlot = null;
        document.getElementById('summary-slot').textContent = '—';

        fetch(`/api/doctor-shifts?doctor_id=${selectedDoctorId}&date=${dateRaw}`)
            .then(res => res.json())
            .then(data => {
                slotGrid.innerHTML = '';

                if (data.length === 0) {
                    slotGrid.innerHTML = '<div style="grid-column: 1 / -1; font-size:13px; color:#ef4444; font-weight:700;">No schedule available on this date.</div>';
                    return;
                }

                data.forEach((slotData) => {
                    const div = document.createElement('div');
                    
                    if (slotData.is_booked) {
                        div.className = 'select-card disabled';
                        div.style.cssText = 'text-align:center;padding:12px;opacity:0.5;cursor:not-allowed;background:#f1f5f9;border:1px solid var(--border);border-radius:12px;';
                        div.innerHTML = `<h4 style="margin:0;color:#94a3b8;">${slotData.time}</h4><p style="color:#ef4444;font-size:11px;margin:0;margin-top:4px;font-weight:600;">Booked</p>`;
                    } else {
                        div.className = 'select-card';
                        div.dataset.time = slotData.time;
                        div.style.cssText = 'text-align:center;padding:12px;cursor:pointer;border:1px solid var(--border);border-radius:12px;transition:.2s;';
                        div.innerHTML = `<h4 style="margin:0;">${slotData.time}</h4><p style="color:var(--primary-green);font-size:11px;margin:0;margin-top:4px;font-weight:600;">Available</p>`;
                        
                        div.addEventListener('click', () => {
                            document.querySelectorAll('#slotGrid .select-card:not(.disabled)').forEach(c => {
                                c.style.borderColor = 'var(--border)';
                                c.style.background = 'transparent';
                            });
                            div.style.borderColor = 'var(--primary-green)';
                            div.style.background = 'var(--light-green)';
                            
                            selectedSlot = slotData.time;
                            selectedScheduleId = slotData.id_schedule;
                            document.getElementById('summary-slot').textContent = slotData.time + ' WIB';
                        });
                    }
                    slotGrid.appendChild(div);
                });
            })
            .catch(err => {
                slotGrid.innerHTML = '<p style="grid-column: 1 / -1; font-size:13px; color:#ef4444;">Server Error. Cannot fetch schedule.</p>';
            });
    }

    const dateInput = document.getElementById('appointmentDate');
    const today = new Date().toISOString().slice(0,10);
    dateInput.min = today;
    dateInput.value = today;

    dateInput.addEventListener('change', () => {
      const d = new Date(dateInput.value);
      document.getElementById('summary-date').textContent = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
      fetchShifts();
    });
    dateInput.dispatchEvent(new Event('change'));

    const docCards = document.querySelectorAll('.doc-card');
    docCards.forEach(card => {
        card.addEventListener('click', () => {
            docCards.forEach(c => {
                c.style.borderColor = 'var(--border)';
                c.style.background = 'var(--white)';
            });
            card.style.borderColor = 'var(--primary-green)';
            card.style.background = 'var(--light-green)';

            selectedDoctorId = card.dataset.docId;
            selectedDoctorName = card.dataset.docName;
            selectedDoctorSpec = card.dataset.spec;
            document.getElementById('summary-doctor').textContent = selectedDoctorName;
            
            fetchShifts();
        });
    });

    if(docCards.length > 0) {
        selectedDoctorId = docCards[0].dataset.docId;
        selectedDoctorName = docCards[0].dataset.docName;
        selectedDoctorSpec = docCards[0].dataset.spec;
        document.getElementById('summary-doctor').textContent = selectedDoctorName;
        fetchShifts(); // <-- Panggil AJAX
    }

    document.getElementById('btnConfirmPay').addEventListener('click', () => {
      const date = document.getElementById('appointmentDate').value;
      const alertModal = document.getElementById('alertModal');
      const alertMsg = document.getElementById('alertMessage');

      function showError(msg) {
          alertMsg.textContent = msg;
          alertModal.classList.add('active');
      }

      if (!date) { showError('Please select an appointment date first.'); return; }
      if (!selectedDoctorId) { showError('Please select a doctor from the list.'); return; }
      if (!selectedSlot) { 
          showError('No shift selected! Please choose a valid date that has an available schedule.'); 
          return; 
      }

      let consultationFee = 150000;
      
      if (selectedClinic === 'Dental Clinic') {
          consultationFee = 250000;
      } else if (selectedClinic === 'Emergency Care') {
          consultationFee = 350000;
      }
      
      let adminFee = 15000;
      let totalFee = consultationFee + adminFee;

      const formatRp = (angka) => 'Rp ' + angka.toLocaleString('id-ID');

      const bookingData = {
        clinic: selectedClinic,
        doctor_id: selectedDoctorId,
        doctor: selectedDoctorName,
        specialty: selectedDoctorSpec,
        date_raw: date,
        date: document.getElementById('summary-date').textContent,
        time: selectedSlot, 
        id_schedule: selectedScheduleId, 
        fee: formatRp(consultationFee), 
        adminFee: formatRp(adminFee), 
        total: formatRp(totalFee)
      };
      
      sessionStorage.setItem('mc_booking', JSON.stringify(bookingData));
      window.location.href = "{{ url('/patient/checkout') }}";
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>

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
            { color:'#94a3b8', title:'<span style="display:flex;align-items:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;color:#059669;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> All Clear</span>', body: 'No new notifications right now.' }
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
  </script>
</body>
</html>