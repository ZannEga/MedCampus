<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Checkout - MedCampus</title>
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
      <div class="nav-profile" style="position: relative;">
        <div class="bell-wrapper" style="color:var(--text-gray);cursor:pointer;display:flex;align-items:center;margin-right:12px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        </div>
        
        <div id="mcProfileToggle" onclick="toggleDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px; margin-left:16px; border: 1px solid var(--border);">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-right: 4px;">▼</span>
        </div>

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
      <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('mcDropdownMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
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
    <h1 style="margin-bottom:8px;">Payment Checkout</h1>
    <p style="color:var(--text-gray);margin-bottom:40px;">Review your appointment details and complete the payment to secure your slot.</p>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:40px;">
      <!-- KIRI: INFORMASI -->
      <div>
        <h3 style="margin-bottom:16px;">Appointment Summary</h3>
        <div class="card card-shadow grid-2">
          <div>
            <p style="font-size:11px;color:var(--text-gray);font-weight:700;text-transform:uppercase;">Clinic &amp; Service</p>
            <p id="co-clinic" style="font-weight:600;font-size:16px;">—</p>
            <p id="co-specialty" style="font-size:13px;color:var(--text-gray);margin-bottom:16px;">—</p>
            <div style="display:flex;gap:12px;align-items:center;background:var(--bg-gray);padding:12px;border-radius:8px;">
              <div style="width:40px;height:40px;background:var(--primary-green);color:white;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-weight:bold;">DR</div>
              <div>
                <h4 id="co-doctor" style="font-size:14px;">—</h4>
                <p id="co-doctor-spec" style="font-size:12px;color:var(--primary-green);">—</p>
              </div>
            </div>
          </div>
          <div>
            <p style="font-size:11px;color:var(--text-gray);font-weight:700;text-transform:uppercase;">Schedule</p>
            <p id="co-date" style="font-weight:600;font-size:16px;">—</p>
            <p id="co-slot" style="font-size:13px;color:var(--text-gray);margin-bottom:16px;">—</p>
            <div style="background:#eff6ff;color:#1d4ed8;padding:12px;border-radius:8px;font-size:12px;">
              ⏱ Arrival at least 15 mins before schedule is recommended.
            </div>
          </div>
        </div>

        <h3 style="margin-top:32px;margin-bottom:16px;">Select Payment Method</h3>
        <div class="card card-shadow">
          <div class="payment-card active">
            <div style="display:flex;gap:16px;align-items:center;">
              <div style="width:20px;height:20px;border-radius:50%;border:6px solid var(--primary-green);background:white;flex-shrink:0;"></div>
              <div>
                <h4 style="font-size:15px;">Student ID Balance</h4>
                <p style="font-size:12px;color:var(--text-gray);">Fast &amp; direct deduction from your campus account</p>
              </div>
            </div>
            <h4 style="color:var(--primary-green);" id="co-fee-show">Rp 165.000</h4>
          </div>
        </div>
      </div>

      <!-- KANAN: BILL & FORM RAHASIA -->
      <div>
        <form action="{{ url('/patient/store-booking') }}" method="POST" class="card card-shadow" id="checkoutForm">
          @csrf
          <input type="hidden" name="doctor_id" id="form_doctor_id">
          <input type="hidden" name="date_raw" id="form_date_raw">
          <input type="hidden" name="booking_time" id="form_booking_time">
          <input type="hidden" name="id_schedule" id="form_id_schedule">

          <h3 style="margin-bottom:24px;">Bill Breakdown</h3>
          <div class="flex-between" style="margin-bottom:16px;font-size:14px;">
            <span style="color:var(--text-gray);">Consultation Fee</span>
            <span id="co-fee">—</span>
          </div>
          <div class="flex-between" style="margin-bottom:24px;font-size:14px;border-bottom:1px dashed var(--border);padding-bottom:24px;">
            <span style="color:var(--text-gray);">Service Fee</span>
            <span id="co-admin-fee">—</span>
          </div>
          <div class="flex-between" style="margin-bottom:24px;font-size:18px;font-weight:700;">
            <span>Total Amount</span>
            <span id="co-total" style="color:var(--primary-green);">—</span>
          </div>
          
          <button type="submit" class="btn btn-primary" id="btnPay" style="width:100%;text-align:center;">Confirm &amp; Pay →</button>
        </form>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script>
    const bookingStr = sessionStorage.getItem('mc_booking');

    if (!bookingStr) {
      alert('No booking data found. Redirecting to Booking Page...');
      window.location.href = "{{ url('/patient/booking') }}";
    } else {
      const booking = JSON.parse(bookingStr);

      document.getElementById('co-clinic').textContent      = booking.clinic;
      document.getElementById('co-specialty').textContent   = booking.specialty || 'Consultation';
      document.getElementById('co-doctor').textContent      = booking.doctor;
      document.getElementById('co-doctor-spec').textContent = booking.specialty;
      document.getElementById('co-date').textContent        = booking.date;
      document.getElementById('co-slot').textContent        = booking.time + ' WIB';
      document.getElementById('co-fee').textContent         = booking.fee;
      document.getElementById('co-admin-fee').textContent   = booking.adminFee;
      document.getElementById('co-total').textContent       = booking.total;
      document.getElementById('co-fee-show').textContent    = booking.total;

      document.getElementById('form_doctor_id').value = booking.doctor_id;
      document.getElementById('form_date_raw').value = booking.date_raw;
      document.getElementById('form_booking_time').value = booking.time;
      document.getElementById('form_id_schedule').value = booking.id_schedule;
    }
  </script>

  <style>
    .spin-animation { animation: spin 1s linear infinite; margin-right: 8px; vertical-align: middle; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
  </style>

  <script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault(); 
        
        const form = this;
        const btn = document.getElementById('btnPay');

        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spin-animation"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="4.93" x2="19.07" y2="7.76"></line></svg> Processing Payment...';
        btn.style.opacity = '0.7';
        btn.style.cursor = 'not-allowed';
        btn.style.pointerEvents = 'none';

        setTimeout(() => {
            form.submit();
        }, 2500);
    });
  </script>
</body>
</html>