<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body class="auth-page">
  <main class="auth-container">
    <section class="auth-card">
      <h1>Create an Account</h1>

      <div class="auth-toggle">
        <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/register') }}" class="active">Register</a>
      </div>

      <form action="{{ url('/register') }}" method="POST">
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="e.g. Andy" required>
          </div>
          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" placeholder="e.g. Jackson" required>
          </div>
        </div>

        <div class="form-group">
          <label for="uni_id">University ID (NIM)</label>
          <div class="input-wrapper has-icon">
            <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <input type="text" id="uni_id" name="uni_id" placeholder="e.g. 187241097" required>
          </div>
        </div>

        <div class="form-group">
          <label for="reg_email">University Email</label>
          <div class="input-wrapper has-icon">
            <svg class="icon-left" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <input type="email" id="reg_email" name="email" placeholder="your@email.com" required autocomplete="username">
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper has-icon has-icon-right">
            <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
            <svg class="icon-right" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
          </div>
        </div>

        <label class="checkbox-container">
          <input type="checkbox" name="terms">
          <div class="checkmark"><svg viewBox="0 0 12 12"><polyline points="3 6 5 8 9 4"></polyline></svg></div>
          <span>I agree to the <a href="javascript:void(0)" onclick="openPolicyModal('termsModal')">Terms of Service</a> and <a href="javascript:void(0)" onclick="openPolicyModal('privacyModal')">Privacy Policy</a>.</span>
        </label>

        <button type="submit" class="btn-submit">Create Account</button>
      </form>

      <p class="auth-footer-text" style="margin-top:16px;">
        Are you a doctor or staff? Contact your admin to get access.
      </p>
    </section>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/guest.js') }}"></script>
</script>

  <div id="termsModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div class="policy-card" style="background:white;border-radius:16px;padding:32px;max-width:500px;width:calc(100% - 32px);max-height:80vh;display:flex;flex-direction:column;box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:12px;color:var(--primary-green, #529b2e);">Terms of Service</h2>
      <div style="overflow-y:auto;padding-right:12px;font-size:13px;line-height:1.6;color:#475569;margin-bottom:24px;">
        <h4 style="color:#151e2d;margin:12px 0 4px;">1. Account Eligibility</h4>
        <p style="margin:0;">The MedCampus portal is exclusively designed for registered students, faculty, and administrative staff of the university. By creating an account, you confirm that the University ID (NIM/NIP) provided is accurate.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">2. Appointment Booking</h4>
        <p style="margin:0;">MedCampus operates on a strict Time-Slot system. Users are expected to arrive at least 15 minutes prior to their time slot. Late arrivals may be placed in the waiting queue.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">3. System Misuse</h4>
        <p style="margin:0;">Any attempt to manipulate the queue system or input false medical data will result in immediate account termination.</p>
      </div>
      <button onclick="closePolicyModal('termsModal')" style="width:100%;background:none;border:1px solid #e2e8f0;padding:12px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;margin-top:auto;">Tutup / Close</button>
    </div>
  </div>

  <div id="privacyModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:999;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div class="policy-card" style="background:white;border-radius:16px;padding:32px;max-width:500px;width:calc(100% - 32px);max-height:80vh;display:flex;flex-direction:column;box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:12px;color:var(--primary-green, #529b2e);">Privacy Policy</h2>
      <div style="overflow-y:auto;padding-right:12px;font-size:13px;line-height:1.6;color:#475569;margin-bottom:24px;">
        <h4 style="color:#151e2d;margin:12px 0 4px;">1. Data Collection</h4>
        <p style="margin:0;">MedCampus collects essential personal information, including your Full Name, University ID, and Email. This data is strictly used to manage your clinic appointments effectively.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">2. Medical Records Confidentiality</h4>
        <p style="margin:0;">All medical records, diagnoses, symptoms, and prescriptions are strictly confidential. This sensitive health information is exclusively accessible only to attending medical practitioners. MedCampus will never share your medical data without explicit written consent.</p>
        
        <h4 style="color:#151e2d;margin:12px 0 4px;">3. Data Security</h4>
        <p style="margin:0;">We employ standard security measures to protect your health information. Users must ensure they log out after using shared university devices.</p>
      </div>
      <button onclick="closePolicyModal('privacyModal')" style="width:100%;background:none;border:1px solid #e2e8f0;padding:12px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;margin-top:auto;">Tutup / Close</button>
    </div>
  </div>

  <script>
    function openPolicyModal(modalId) {
      const modal = document.getElementById(modalId);
      const card = modal.querySelector('.policy-card');
      modal.style.opacity = '1';
      modal.style.pointerEvents = 'auto';
      card.style.transform = 'translateY(0)';
    }

    function closePolicyModal(modalId) {
      const modal = document.getElementById(modalId);
      const card = modal.querySelector('.policy-card');
      modal.style.opacity = '0';
      modal.style.pointerEvents = 'none';
      card.style.transform = 'translateY(16px)';
    }

    window.addEventListener('click', function(e) {
      const tModal = document.getElementById('termsModal');
      const pModal = document.getElementById('privacyModal');
      if (e.target === tModal) closePolicyModal('termsModal');
      if (e.target === pModal) closePolicyModal('privacyModal');
    });
  </script>
</body>
</html>
