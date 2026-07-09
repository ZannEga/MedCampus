<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Confirmed - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body style="background:var(--bg-gray);">
  <main class="container" style="padding:80px 0;text-align:center;">
    <div class="success-circle">
      <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    </div>
    <h1 style="font-size:32px;margin-bottom:12px;">Appointment Confirmed!</h1>
    <p style="color:var(--text-gray);margin-bottom:40px;">Your reservation has been successfully booked. You can now view your digital ticket.</p>

    <div class="ticket-wrapper">
      <div style="padding:32px 24px;">
        <p style="font-size:12px;color:var(--text-gray);font-weight:700;letter-spacing:1px;">QUEUE NUMBER</p>
        <h2 style="font-size:64px;color:var(--primary-green);margin-bottom:32px;line-height:1;">
            {{ $latestAppointment ? $latestAppointment->queue_number : '—' }}
        </h2>

        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Appointment ID</span>
          <span style="font-weight:600;">{{ $latestAppointment ? $latestAppointment->id_appointments : '—' }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Clinic</span>
          <span style="font-weight:600;">{{ $latestAppointment ? $latestAppointment->clinic : '—' }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:16px;">
          <span style="color:var(--text-gray);font-size:14px;">Doctor</span>
          <span style="font-weight:600;">{{ $latestAppointment ? $latestAppointment->doctor_name : '—' }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px dashed var(--border);padding-bottom:16px;margin-bottom:32px;">
          <span style="color:var(--text-gray);font-size:14px;">Date &amp; Time</span>
          <span style="font-weight:600;">
              {{ $latestAppointment ? \Carbon\Carbon::parse($latestAppointment->appointment_date)->format('M d, Y') . ' • ' . date('H:i', strtotime($latestAppointment->booking_time)) : '—' }}
          </span>
        </div>
      </div>
    </div>

    <div style="margin-top:32px;display:flex;gap:16px;justify-content:center;">
      <a href="{{ url('/patient/ticket') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
          <path d="M13 5v2"></path>
          <path d="M13 17v2"></path>
          <path d="M13 11v2"></path>
        </svg>
        View Digital Ticket
      </a>
      
      <a href="{{ url('/patient/dashboard') }}" class="btn btn-outline" style="background:white; display:inline-flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        Return to Home
      </a>
    </div>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/profile-dropdown.js') }}"></script>
  <script src="{{ asset('js/patient.js') }}"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        const el = document.getElementById('qr-canvas');
        if (el && window.QRCode) {
          const data = "MC-" + (document.getElementById("sc-appt-id")?.textContent || "MC-88291");
          new QRCode(el, { text: data, width: el.offsetWidth || 100, height: el.offsetHeight || 100, colorDark:'#151e2d', colorLight:'#ffffff' });
        }
      }, 300);
    });
  </script>
  <script src="{{ asset('js/mobile-nav.js') }}"></script>
</body>
</html>
