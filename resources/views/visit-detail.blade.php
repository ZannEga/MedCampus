<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visit Detail - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">MedCampus</div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
        <a href="{{ url('/patient/history') }}" class="active">Medical History</a>
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

  <main class="main-content container" style="max-width: 800px;">
    
    <div class="flex-between" style="margin-bottom:24px;">
      <a href="{{ url('/patient/history') }}" style="color:var(--text-gray);font-size:14px;font-weight:500;display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
        ← Back to History
      </a>
      <button onclick="window.print()" class="btn btn-outline" style="font-size:13px;padding:8px 16px;background:white;">🖨 Print Record</button>
    </div>

    <div class="card card-shadow" style="padding:0; overflow:hidden; border-radius:12px; margin-bottom:24px;">
      <div style="background:var(--primary-green); color:white; padding:24px 32px; display:flex; justify-content:space-between; align-items:center;">
        <div>
          <h2 style="margin:0; font-size:24px;">Visit Summary</h2>
          <p style="margin:4px 0 0; opacity:0.9; font-size:14px;">Appointment ID: #{{ $detail->id_appointments }}</p>
        </div>
        <div style="text-align:right;">
          <p style="margin:0; font-size:12px; font-weight:700; letter-spacing:1px; opacity:0.9;">DATE</p>
          <h3 style="margin:4px 0 0; font-size:18px;">{{ \Carbon\Carbon::parse($detail->appointment_date)->format('d F Y') }}</h3>
        </div>
      </div>

      <div style="padding:32px; display:grid; grid-template-columns:1fr 1fr; gap:32px;">
        <div>
          <p style="font-size:11px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:4px;">Patient</p>
          <p style="font-size:16px; font-weight:600; margin-bottom:16px;">{{ Auth::user()->user_name }} <span style="font-size:12px; color:var(--text-gray); font-weight:400;">({{ Auth::user()->id_user }})</span></p>
          
          <p style="font-size:11px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:4px;">Clinic</p>
          <p style="font-size:15px; font-weight:600;">{{ $detail->clinic }}</p>
        </div>
        <div>
          <p style="font-size:11px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:4px;">Attending Doctor</p>
          <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
            <div style="width:36px; height:36px; background:var(--light-green); color:var(--primary-green); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:14px;">
              {{ strtoupper(substr($detail->doctor_name, 0, 2)) }}
            </div>
            <div>
              <p style="font-size:15px; font-weight:600; margin:0;">{{ $detail->doctor_name }}</p>
              <p style="font-size:12px; color:var(--text-gray); margin:0;">{{ $detail->specialty ?? 'Consultation' }}</p>
            </div>
          </div>
          
          <p style="font-size:11px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:4px;">Queue Number</p>
          <p style="font-size:15px; font-weight:600;">{{ $detail->queue_number }}</p>
        </div>
      </div>
    </div>

    <!-- KARTU HASIL PEMERIKSAAN -->
    <div class="card card-shadow" style="padding:32px;">
      <h3 style="margin-bottom:24px; font-size:18px; display:flex; align-items:center; gap:8px;">
        <span style="color:var(--primary-green);">📋</span> Medical Assessment
      </h3>

      @if(!$detail->diagnosis)
        <div style="background:#f8fafc; border:1px dashed #cbd5e1; padding:24px; text-align:center; border-radius:8px; color:var(--text-gray);">
          <span style="font-size:24px; display:block; margin-bottom:8px;">⏳</span>
          Medical assessment has not been inputted by the doctor yet.
        </div>
      @else
        <!-- Diagnosis & Notes Asli dari Database -->
        <div style="margin-bottom:24px;">
          <p style="font-size:12px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:8px;">Diagnosis</p>
          <p style="background:var(--bg-gray); border:1px solid var(--border); padding:12px 16px; border-radius:8px; font-size:14px; line-height:1.6;">
            {{ $detail->diagnosis }}
          </p>
        </div>
        
        <div style="margin-bottom:24px;">
          <p style="font-size:12px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:8px;">Doctor's Notes</p>
          <div style="white-space: pre-wrap; line-height: 1.6; background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid var(--border); color: var(--dark-navy); font-size: 14px;">
              {!! nl2br(e($detail->notes)) !!}
          </div>
        </div>

        <!-- Prescription Asli dari Database -->
        <div>
          <p style="font-size:12px; color:var(--text-gray); font-weight:700; text-transform:uppercase; margin-bottom:8px;">Prescription (Rx)</p>
          <div style="background:#fefce8; border:1px solid #fef08a; padding:16px; border-radius:8px;">
            
            @if(count($prescriptions) > 0)
              <ul style="list-style-type:none; margin:0; padding:0; font-family:var(--font-main); font-size:14px; color:#854d0e; font-weight:600;">
                @foreach($prescriptions as $index => $rx)
                  <li style="margin-bottom:8px; display:flex; align-items:flex-start; gap:8px;">
                    <span>{{ $index + 1 }}.</span>
                    <div>
                      {{ $rx->med_name }} — {{ $rx->quantity }} {{ $rx->med_unit }}
                      <div style="font-weight:400; font-size:12px; opacity:0.9; margin-top:2px;">Dosis: {{ $rx->dosage }}</div>
                    </div>
                  </li>
                @endforeach
              </ul>
            @else
              <p style="font-family:var(--font-main); font-size:14px; margin:0; color:#854d0e; font-weight:500;">
                No prescription items recorded for this visit.
              </p>
            @endif

          </div>
          <p style="font-size:11px; color:var(--text-gray); margin-top:8px;">* Please present this detail to the pharmacy counter to collect your medication.</p>
        </div>
      @endif

    </div>
  </main>

</body>
</html>