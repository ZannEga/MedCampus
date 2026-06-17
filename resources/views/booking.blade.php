<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Appointment - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
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
        <div class="bell-wrapper">
          <span class="bell">🔔</span>
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
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: white; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <!-- Info Singkat di dalam Dropdown -->
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: #f8fafc;">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <!-- Link Menu -->
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;">
            <span>👤</span> My Profile
          </a>
          
          <!-- Tombol Logout -->
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);">
            <span>🚪</span> Logout
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
            <div id="dateHint" style="font-size:13px;color:var(--text-gray);padding:12px;background:var(--bg-gray);border-radius:8px;line-height:1.6;">
              📅 Select a date to see available doctors and time slots.
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
                    $rating = ['4.7', '4.8', '4.9', '5.0'][$index % 4];
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
                  <span class="badge" style="background:#fef3c7;color:#b45309;font-size:11px;">⭐ {{ $rating }}</span>
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
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script>
    let selectedClinic = 'General Clinic';
    let selectedSlot   = null; // Diubah jadi null karena belum tahu shiftnya
    let selectedDoctorId = null;
    let selectedDoctorName = '';
    let selectedDoctorSpec = '';

    // 1. Pilih Klinik
    document.querySelectorAll('#clinicGrid .select-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('#clinicGrid .select-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        selectedClinic = card.dataset.clinic;
        document.getElementById('summary-clinic').textContent = selectedClinic;
      });
    });

    // 🌟 2. FUNGSI AJAX: MENGAMBIL SHIFT ASLI DARI DATABASE
    function fetchShifts() {
        const dateRaw = document.getElementById('appointmentDate').value;
        const slotGrid = document.getElementById('slotGrid');
        
        if (!selectedDoctorId || !dateRaw) return;

        // Tampilkan teks loading
        slotGrid.innerHTML = '<p style="grid-column: 1 / -1; font-size:13px; color:var(--text-gray); font-style:italic;">⏳ Checking doctor availability...</p>';
        selectedSlot = null;
        document.getElementById('summary-slot').textContent = '—';

        // Panggil API Laravel
        fetch(`/api/doctor-shifts?doctor_id=${selectedDoctorId}&date=${dateRaw}`)
            .then(res => res.json())
            .then(data => {
                slotGrid.innerHTML = ''; // Bersihkan loading

                if (data.length === 0) {
                    slotGrid.innerHTML = '<p style="grid-column: 1 / -1; font-size:13px; color:#ef4444; font-weight:700;">❌ No shifts available for this doctor on the selected date.</p>';
                    return;
                }

                // Gambar ulang tombol Shift sesuai data Admin!
                data.forEach((jadwal, index) => {
                    let timeLabel = 'Available';
                    if(jadwal.shift.toLowerCase().includes('morning')) timeLabel = '08:00 - 12:00';
                    else if(jadwal.shift.toLowerCase().includes('afternoon')) timeLabel = '13:00 - 17:00';
                    else timeLabel = jadwal.shift; // Kalau admin ngetik shift aneh

                    const div = document.createElement('div');
                    div.className = 'select-card' + (index === 0 ? ' active' : '');
                    div.dataset.slot = jadwal.shift;
                    div.style.cssText = 'text-align:center;padding:12px;';
                    div.innerHTML = `
                        <h4 style="margin:0;text-transform:capitalize;">${jadwal.shift}</h4>
                        <p style="color:var(--primary-green);">${timeLabel}</p>
                    `;

                    // Event Listener untuk tombol shift baru
                    div.addEventListener('click', () => {
                        document.querySelectorAll('#slotGrid .select-card').forEach(c => c.classList.remove('active'));
                        div.classList.add('active');
                        selectedSlot = jadwal.shift;
                        document.getElementById('summary-slot').textContent = jadwal.shift + ' WIB';
                    });

                    slotGrid.appendChild(div);

                    // Pilih shift pertama secara otomatis
                    if(index === 0) {
                        selectedSlot = jadwal.shift;
                        document.getElementById('summary-slot').textContent = jadwal.shift + ' WIB';
                    }
                });
            })
            .catch(err => {
                slotGrid.innerHTML = '<p style="grid-column: 1 / -1; font-size:13px; color:#ef4444;">Server Error. Cannot fetch schedule.</p>';
            });
    }

    // 3. Setup Tanggal & Picu AJAX saat tanggal diganti
    const dateInput = document.getElementById('appointmentDate');
    const today = new Date().toISOString().slice(0,10);
    dateInput.min = today;
    dateInput.value = today;

    dateInput.addEventListener('change', () => {
      const d = new Date(dateInput.value);
      document.getElementById('summary-date').textContent = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
      fetchShifts(); // <-- Panggil AJAX
    });
    dateInput.dispatchEvent(new Event('change')); // Trigger pertama kali

    // 4. Pilih Dokter & Picu AJAX saat dokter diganti
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
            
            fetchShifts(); // <-- Panggil AJAX
        });
    });

    // Pilih dokter pertama secara otomatis saat baru buka halaman
    if(docCards.length > 0) {
        selectedDoctorId = docCards[0].dataset.docId;
        selectedDoctorName = docCards[0].dataset.docName;
        selectedDoctorSpec = docCards[0].dataset.spec;
        document.getElementById('summary-doctor').textContent = selectedDoctorName;
        fetchShifts(); // <-- Panggil AJAX
    }

    // 5. Tombol Proceed To Checkout
    document.getElementById('btnConfirmPay').addEventListener('click', () => {
      const date = document.getElementById('appointmentDate').value;
      if (!date) { alert('Please select a date.'); return; }
      if (!selectedDoctorId) { alert('Please select a doctor.'); return; }
      if (!selectedSlot) { 
          alert('No shift selected! Please choose a valid date that has an available schedule.'); 
          return; 
      }

      const bookingData = {
        clinic: selectedClinic,
        doctor_id: selectedDoctorId,
        doctor: selectedDoctorName,
        specialty: selectedDoctorSpec,
        date_raw: date,
        date: document.getElementById('summary-date').textContent,
        slot: selectedSlot,
        fee: 'Rp 150.000', adminFee: 'Rp 15.000', total: 'Rp 165.000'
      };
      
      sessionStorage.setItem('mc_booking', JSON.stringify(bookingData));
      window.location.href = "{{ url('/patient/checkout') }}";
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>