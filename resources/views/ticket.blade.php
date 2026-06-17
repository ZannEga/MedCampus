<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Ticket - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
</head>
<body style="background:#f1f5f9;padding:40px 0;">
  <div class="container" style="max-width:800px;margin-bottom:24px;display:flex;justify-content:space-between;">
    <a href="{{ url('/patient/queue-detail') }}" id="btnTicketBack" class="btn btn-outline" style="background:white;border:1px solid var(--border);text-decoration:none;">← Go Back</a>
    <button class="btn btn-primary" onclick="window.print()">🖨 Print Ticket</button>
  </div>

  <div class="container" style="max-width:800px;background:white;border-radius:16px;overflow:hidden;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);padding:0;">
    <div class="ticket-head" style="background:var(--primary-green);color:white;padding:32px 40px;display:flex;justify-content:space-between;align-items:center;">
      <div>
        <h3 style="margin:0;font-size:24px;">MedCampus</h3>
        <p style="font-size:14px;opacity:0.9;margin:0;">Official Appointment Digital Ticket</p>
      </div>
      <div style="text-align:right;">
        <p style="font-size:12px;font-weight:700;letter-spacing:1px;margin:0;opacity:0.9;">QUEUE NUMBER</p>
        <h2 style="font-size:48px;margin:0;line-height:1;">{{ $activeQueue->queue_number }}</h2>
      </div>
    </div>

    <div style="padding:40px;display:grid;grid-template-columns:1fr 1fr;gap:40px;">
      <!-- QR Area -->
      <div style="text-align:center;border-right:1px dashed var(--border);padding-right:40px;">
        <div style="width:200px;height:200px;background:#fed7aa;margin:0 auto 24px;display:flex;justify-content:center;align-items:center;border-radius:12px;">
          <div style="width:120px;height:120px;background:white;border:none;display:flex;align-items:center;justify-content:center;">
            <div id="qr-canvas"></div>
          </div>
        </div>
        <p style="font-size:13px;color:var(--text-gray);">Scan at clinic reception</p>
        <h3 style="color:var(--primary-green);margin-top:8px;">#{{ $activeQueue->id_appointments }}</h3>
      </div>

      <!-- Info Area -->
      <div style="padding-left:20px;">
        <h3 style="margin-bottom:24px;">Patient &amp; Appointment Information</h3>
        <div class="flex-between" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Patient Name</span>
          <span style="font-weight:600;">{{ Auth::user()->user_name }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Student ID (NIM)</span>
          <span style="font-weight:600;font-family:monospace;">{{ Auth::user()->id_user }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Clinic</span>
          <span style="font-weight:600;color:var(--primary-green);">{{ $activeQueue->clinic }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Attending Doctor</span>
          <span style="font-weight:600;">{{ $activeQueue->doctor_name }}</span>
        </div>
        <div class="flex-between" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Date</span>
          <span style="font-weight:600;">{{ \Carbon\Carbon::parse($activeQueue->appointment_date)->format('l, d M Y') }}</span>
        </div>
        <div class="flex-between" style="padding-bottom:12px;">
          <span style="color:var(--text-gray);font-size:14px;">Estimated Time</span>
          <span style="font-weight:600;">{{ $estimatedTime }} WIB</span>
        </div>
      </div>
    </div>

    <div style="background:var(--bg-gray);padding:24px 40px;border-top:1px solid var(--border);">
      <h4 style="margin-bottom:8px;color:var(--dark-navy);">ⓘ Important Instructions:</h4>
      <ul style="font-size:13px;color:var(--text-gray);padding-left:20px;list-style-type:disc;">
        <li style="margin-bottom:4px;">Please arrive at the clinic at least 10 minutes before your estimated time.</li>
        <li style="margin-bottom:4px;">Present this digital ticket or a printed copy at the reception counter.</li>
        <li>Ensure you have your Student ID (KTM) ready for verification.</li>
      </ul>
    </div>
  </div>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script>
    // Generate QR Code Asli berdasarkan ID Database!
    document.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        const el = document.getElementById('qr-canvas');
        if (el && window.QRCode) {
          const data = "{{ $activeQueue->id_appointments }}";
          new QRCode(el, { text: data, width: 100, height: 100, colorDark:'#151e2d', colorLight:'#ffffff' });
        }
      }, 300);
    });
  </script>
</body>
</html>