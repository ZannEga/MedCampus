<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queue Details - MedCampus</title>
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
        <a href="{{ url('/patient/dashboard') }}" class="active">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
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
    </div>
  </nav>

  <main class="main-content container">
    <a href="{{ url('/patient/dashboard') }}" style="color:var(--text-gray);font-size:14px;font-weight:500;display:inline-flex;align-items:center;gap:8px;margin-bottom:24px;text-decoration:none;">
      ← Back to Dashboard
    </a>

    <!-- INI GRID UTAMA (Yang Tadi Bocor) -->
    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:32px;">

      <!-- KIRI: TIKET & TOMBOL -->
      <div>
        <div class="card card-shadow" style="border-top:6px solid var(--primary-green);padding:32px;margin-bottom:24px;">
          <div class="flex-between" style="align-items:flex-start;">
            <div>
              <p style="font-size:11px;font-weight:700;color:var(--primary-green);letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Your Current Ticket</p>
              <p style="font-size:14px;color:var(--text-gray);font-weight:500;margin-bottom:4px;">{{ Auth::user()->user_name }}</p>
              <h1 style="font-size:56px;line-height:1;color:var(--dark-navy);margin-bottom:12px;">{{ $activeQueue->queue_number }}</h1>
              <p style="color:var(--text-gray);font-size:15px;">Please wait for your number to be called.</p>
            </div>
            <div style="background:var(--bg-gray);padding:16px;border-radius:12px;text-align:center;border:1px solid var(--border);">
              <div id="qr-canvas" style="width:80px;height:80px;background:white;margin:0 auto 8px;"></div>
              <span style="font-size:9px;font-weight:700;color:var(--text-gray);letter-spacing:1px;">SCAN FOR CHECK-IN</span>
            </div>
          </div>

          <hr style="border:none;border-bottom:1px solid var(--border);margin:32px 0;">

          <div>
            <div class="flex-between" style="margin-bottom:8px;">
              <h3 style="display:flex;align-items:center;gap:8px;font-size:18px;">
                <span style="color:var(--primary-green);">👥</span>
                <span>{{ $aheadCount }} people ahead of you</span>
              </h3>
              <span style="font-size:13px;font-weight:600;color:var(--primary-green);">{{ $progress }}% Complete</span>
            </div>
            <div class="progress-container" style="background:#e2e8f0;border-radius:8px;height:8px;overflow:hidden;">
              <div style="background:var(--primary-green);height:100%;width:{{ $progress }}%;transition:width 0.5s;"></div>
            </div>
            <p style="font-size:13px;color:var(--text-gray);margin-top:12px;display:flex;align-items:center;gap:6px;">
              <span>ⓘ</span> You are almost next. Please stay near the waiting area.
            </p>
          </div>
        </div>

        <div style="display:flex;gap:16px;">
          <a href="{{ url('/patient/ticket') }}" class="btn btn-primary" style="flex:1;font-size:15px;text-align:center;text-decoration:none;">📥 Download Ticket</a>
          <!-- TOMBOL ANTI BADAI (Pakai classList.add) -->
          <button onclick="document.getElementById('cancelModal').classList.add('active')" type="button" class="btn btn-outline" style="flex:1;background:var(--bg-gray);border:1px solid var(--border);font-size:15px;">⊗ Cancel Appointment</button>
        </div>
      </div> <!-- Akhir Sisi Kiri -->

      <!-- KANAN: DETAILS -->
      <div>
        <div class="card card-shadow" style="padding:32px;">
          <h2 style="font-size:20px;margin-bottom:32px;">Appointment Details</h2>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="font-size:24px;">🏥</div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Clinic</p>
              <p style="font-weight:600;font-size:15px;">{{ $activeQueue->clinic }}</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="font-size:24px;">👨‍⚕️</div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Doctor</p>
              <p style="font-weight:600;font-size:15px;">{{ $activeQueue->doctor_name }}</p>
              <p style="font-size:12px;color:var(--text-gray);">{{ $activeQueue->specialty ?? 'Consultation' }}</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:24px;">
            <div style="font-size:24px;">🕒</div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Estimated Service Time</p>
              <p style="font-weight:600;font-size:15px;">Today, {{ $estimatedTime }} WIB</p>
            </div>
          </div>

          <div class="detail-item" style="display:flex;gap:16px;margin-bottom:32px;">
            <div style="font-size:24px;">💬</div>
            <div>
              <p style="font-size:13px;color:var(--text-gray);margin-bottom:2px;">Status</p>
              <p style="font-weight:600;font-size:15px;color:#d97706;">
                {{ $activeQueue->status == 'I' ? 'In Progress' : 'Waiting in Queue' }}
              </p>
            </div>
          </div>

          <div style="background:#f8fafc;padding:16px;border-radius:8px;border:1px solid var(--border);">
            <h4 style="font-size:14px;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
              <span style="color:var(--primary-green);">🔔</span> Instructions
            </h4>
            <p style="font-size:13px;color:var(--text-gray);line-height:1.6;">
              Please arrive 10 minutes early. Have your health card and identification ready for verification at the reception desk.
            </p>
          </div>
        </div>
      </div> <!-- Akhir Sisi Kanan -->

    </div>
  </main>

  <!-- MODAL CANCEL -->
  <div id="cancelModal" class="modal-overlay">
    <div class="modal-card">
      <div class="modal-header">
        <div class="modal-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <h2 style="font-size:18px;color:var(--dark-navy);margin:0;">Cancel Appointment</h2>
      </div>
      <p style="color:var(--text-gray);font-size:14px;margin-bottom:24px;line-height:1.6;">
        Are you sure? Your queue position (<strong>{{ $activeQueue->queue_number }}</strong>) will be lost.
      </p>
      
      <!-- FORM PEMBATALAN -->
      <form action="{{ url('/patient/cancel-appointment') }}" method="POST">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $activeQueue->id_appointments }}">
        <div style="display:flex;flex-direction:column;gap:12px;">
          <button type="submit" class="btn btn-primary" style="background:#ef4444;border:none;width:100%;padding:12px;font-size:14px;">Yes, Cancel It</button>
          <!-- Tombol Tutup Modal (Pakai classList.remove) -->
          <button type="button" onclick="document.getElementById('cancelModal').classList.remove('active')" class="btn btn-outline" style="color:var(--primary-green);border-color:var(--border);width:100%;padding:12px;font-size:14px;">No, Keep Appointment</button>
        </div>
      </form>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        const el = document.getElementById('qr-canvas');
        if (el && window.QRCode) {
          const data = "{{ $activeQueue->id_appointments }}";
          new QRCode(el, { text: data, width: 80, height: 80, colorDark:'#151e2d', colorLight:'#ffffff' });
        }
      }, 300);
    });
  </script>
</body>
</html>