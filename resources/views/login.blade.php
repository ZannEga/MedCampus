<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <script>
    if (localStorage.getItem('mc_dark_mode') === '1') {
        document.documentElement.classList.add('dark-mode');
    }
  </script>
</head>
<body class="auth-page">
  <a href="{{ url('/') }}" style="
    position:fixed; top:20px; left:24px; z-index:10;
    display:inline-flex; align-items:center; gap:7px;
    font-size:13px; font-weight:600; color:var(--text-gray);
    background:var(--white); border:1px solid var(--border);
    padding:7px 14px; border-radius:20px; text-decoration:none;
    box-shadow:0 2px 8px rgba(0,0,0,0.07); transition:all .2s;
  " onmouseover="this.style.borderColor='var(--primary-green)';this.style.color='var(--primary-green)'"
     onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-gray)'">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <polyline points="15 18 9 12 15 6"></polyline>
    </svg>
    Back to Home
  </a>

  <main class="auth-container">
    <section class="auth-card">
      <div style="text-align:center; margin-bottom: 24px;">
        <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; color: var(--primary-green);"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
      </div>

      <h1 id="pageTitle" style="margin-bottom: 8px;">MedCampus Portal</h1>
      <p style="text-align: center; color: var(--text-gray); font-size: 14px; margin-bottom: 32px;">Sign in to access your dashboard</p>

      <div class="auth-toggle" id="authToggle">
        <a href="{{ url('/login') }}" class="active" id="loginLink">Login</a>
        <a href="{{ url('/register') }}" id="registerLink">Register</a>
      </div>

      <form id="loginForm" action="{{ url('/login') }}" method="POST">
        @csrf
        @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid #fecaca;">
              ⚠️ {{ $errors->first() }}
            </div>
          @endif
        <div class="form-group">
          <div class="label-flex">
            <label for="email" id="emailLabel">University ID or Email</label>
          </div>
          <div class="input-wrapper has-icon">
            <svg class="icon-left" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <input type="text" id="email" name="email" placeholder="your@email.com" required autocomplete="username">
          </div>
        </div>

        <div class="form-group">
          <div class="label-flex">
            <label for="password">Password</label>
            <a href="javascript:void(0)" id="forgotLink">forgot password?</a>
          </div>
          <div class="input-wrapper has-icon has-icon-right">
            <svg class="icon-left" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <input type="password" id="password" name="password" placeholder="••••••••••••••" required autocomplete="current-password">
            <svg class="icon-right" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
          </div>
        </div>

        <label class="checkbox-container">
          <input type="checkbox" id="rememberMe" checked>
          <div class="checkmark"><svg viewBox="0 0 12 12"><polyline points="3 6 5 8 9 4"></polyline></svg></div>
          Remember me on this device?
        </label>

        <button type="submit" class="btn-submit" id="submitBtn">Sign In</button>
      </form>

      <p class="auth-footer-text">By signing in, you agree to our <a href="javascript:void(0)" onclick="openPolicyModal('termsModal')">Terms of Service</a> and <a href="javascript:void(0)" onclick="openPolicyModal('privacyModal')">Privacy Policy</a>.</p>
    </section>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/guest.js') }}"></script>
  
  <script>
    document.getElementById('loginForm').addEventListener('submit', e => {
      const email    = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;

      if (!email || !password) {
        e.preventDefault(); 
        Toast.show('Please fill in all fields.', 'error'); 
        return;
      }

      const btn = document.getElementById('submitBtn');
      btn.textContent = 'Authenticating...';
      btn.disabled = true;
      btn.style.opacity = '0.7';
    });
  </script>

  <div id="forgotModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:300;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div id="forgotCard" style="background:white;border-radius:16px;padding:36px;max-width:400px;width:calc(100% - 32px);box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:8px;">Reset Password</h2>
      <p style="font-size:13px;color:#64748b;margin-bottom:24px;">Enter your registered email and we'll send a reset link.</p>
      <div style="margin-bottom:16px;">
        <label style="font-size:12px;font-weight:500;color:#151e2d;display:block;margin-bottom:8px;">Email Address</label>
        <input type="email" id="forgotEmail" placeholder="your@email.com"
          style="width:100%;padding:12px 14px;border:1px solid #e2e8f0;border-radius:6px;font-size:13px;outline:none;font-family:inherit;">
      </div>
      <button id="sendResetBtn" style="width:100%;background:var(--primary-green, #529b2e);color:white;padding:12px;border:none;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;margin-bottom:12px;">Send Reset Link</button>
      <button id="closeForgotModal" style="width:100%;background:none;border:1px solid #e2e8f0;padding:11px;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;color:#64748b;">Cancel</button>
    </div>
  </div>
  
  <script>
    const forgotModal = document.getElementById('forgotModal');
    const forgotCard  = document.getElementById('forgotCard');

    document.getElementById('forgotLink')?.addEventListener('click', e => {
      e.preventDefault();
      forgotModal.style.opacity = '1'; forgotModal.style.pointerEvents = 'auto';
      forgotCard.style.transform = 'translateY(0)';
    });

    function closeForgot() {
      forgotModal.style.opacity = '0'; forgotModal.style.pointerEvents = 'none';
      forgotCard.style.transform = 'translateY(16px)';
    }

    document.getElementById('closeForgotModal')?.addEventListener('click', closeForgot);
    forgotModal?.addEventListener('click', e => { if (e.target === forgotModal) closeForgot(); });

    document.getElementById('sendResetBtn')?.addEventListener('click', () => {
      const email = document.getElementById('forgotEmail').value.trim();
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        Toast.show('Enter a valid email address.', 'error'); return;
      }
      Toast.show('Reset link sent to ' + email + '. Check your inbox.', 'success', 4000);
      closeForgot();
    });
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