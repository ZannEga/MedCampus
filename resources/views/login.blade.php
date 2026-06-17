<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <style>
    .role-badge {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;
      letter-spacing: 0.5px; text-transform: uppercase;
      margin: 0 auto 20px; text-align: center;
    }
    .role-badge.patient { background: #e6f4ea; color: #529b2e; }
    .role-badge.doctor  { background: #eff6ff; color: #2563eb; }
    .role-badge.admin   { background: #fdf4ff; color: #9333ea; }

    .btn-submit.doctor { background: #2563eb; }
    .btn-submit.doctor:hover { background: #1d4ed8; }
    .btn-submit.admin  { background: #9333ea; }
    .btn-submit.admin:hover  { background: #7e22ce; }

    .role-switcher {
      display: flex; justify-content: center; gap: 8px;
      margin-top: 20px; padding-top: 20px;
      border-top: 1px solid var(--border);
    }
    .role-switch-btn {
      font-size: 11px; font-weight: 600; padding: 5px 12px;
      border-radius: 20px; text-decoration: none; color: var(--text-gray);
      border: 1px solid var(--border); transition: all .2s;
      background: white;
    }
    .role-switch-btn:hover { border-color: var(--text-gray); color: var(--dark-navy); }
    .role-switch-btn.active-patient { background: #e6f4ea; color: #529b2e; border-color: #529b2e; }
    .role-switch-btn.active-doctor  { background: #eff6ff; color: #2563eb; border-color: #2563eb; }
    .role-switch-btn.active-admin   { background: #fdf4ff; color: #9333ea; border-color: #9333ea; }

  </style>
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
      <div style="text-align:center;">
        <div id="roleBadge" class="role-badge"></div>
      </div>

      <h1 id="pageTitle">Welcome Back</h1>

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
            <input type="text" id="email" name="email" placeholder="email@medcampus.edu" required autocomplete="username">
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

      <div class="divider">OR CONTINUE WITH</div>
      <button class="btn-sso">
        <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
        University SSO
      </button>

      <div class="role-switcher">
        <a href="{{ url('/login') }}" class="role-switch-btn" id="switchPatient">🎓 Pasien</a>
        <a href="{{ url('/login') }}?role=doctor" class="role-switch-btn" id="switchDoctor">🩺 Dokter</a>
        <a href="{{ url('/login') }}?role=admin" class="role-switch-btn" id="switchAdmin">⚙️ Admin</a>
      </div>

      <p class="auth-footer-text">By signing in, you agree to our <a href="javascript:void(0)" onclick="Toast.show('Terms of Service is not available in the demo.', 'info')">Terms of Service</a> and <a href="javascript:void(0)" onclick="Toast.show('Privacy Policy is not available in the demo.', 'info')">Privacy Policy</a>.</p>
    </section>
  </main>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="{{ asset('js/app-data.js') }}"></script>
  <script src="{{ asset('js/guest.js') }}"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    const role   = (params.get('role') || 'patient').toLowerCase();

    const CONFIG = {
      patient: {
        label:       '🎓 Patient Portal',
        badgeClass:  'patient',
        title:       'Welcome Back',
        emailLabel:  'University ID or Email',
        placeholder: 'student@university.edu',
        submitClass: '',
        submitText:  'Sign In',
        redirect:    '{{ url("/patient/dashboard") }}',
        allowedRole: ['Student'],
        hint: {
          emails: ['b.santoso@student.med.edu', 'm.thorne@student.med.edu'],
          password: 'medcampus123'
        }
      },
      doctor: {
        label:       '🩺 Doctor Portal',
        badgeClass:  'doctor',
        title:       'Doctor Login',
        emailLabel:  'Doctor Email',
        placeholder: 'doctor@medcampus.edu',
        submitClass: 'doctor',
        submitText:  'Sign In to Doctor Portal',
        redirect:    '{{ url("/doctor/dashboard") }}',
        allowedRole: ['Doctor'],
        hint: {
          emails: ['s.jenkins@medcampus.edu', 'e.watson@medcampus.edu'],
          password: 'medcampus123'
        }
      },
      admin: {
        label:       '⚙️ Admin Panel',
        badgeClass:  'admin',
        title:       'Admin Login',
        emailLabel:  'Admin Email',
        placeholder: 'admin@medcampus.edu',
        submitClass: 'admin',
        submitText:  'Sign In to Admin Panel',
        redirect:    '{{ url("/admin/dashboard") }}',
        allowedRole: ['Admin'],
        hint: {
          emails: ['admin@medcampus.edu'],
          password: 'admin123'
        }
      }
    };

    const cfg = CONFIG[role] || CONFIG.patient;

    document.getElementById('roleBadge').textContent  = cfg.label;
    document.getElementById('roleBadge').className    = `role-badge ${cfg.badgeClass}`;
    document.getElementById('pageTitle').textContent  = cfg.title;
    document.getElementById('emailLabel').textContent = cfg.emailLabel;
    document.getElementById('email').placeholder      = cfg.placeholder;
    document.getElementById('submitBtn').textContent  = cfg.submitText;
    if (cfg.submitClass) document.getElementById('submitBtn').classList.add(cfg.submitClass);

    if (role !== 'patient') {
      document.getElementById('authToggle').style.display = 'none';
    }

    document.getElementById('switchPatient').className = 'role-switch-btn' + (role === 'patient' ? ' active-patient' : '');
    document.getElementById('switchDoctor').className  = 'role-switch-btn' + (role === 'doctor'  ? ' active-doctor'  : '');
    document.getElementById('switchAdmin').className   = 'role-switch-btn' + (role === 'admin'   ? ' active-admin'   : '');

    document.getElementById('loginForm').addEventListener('submit', e => {
      const email    = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;

      if (!email || !password) {
        e.preventDefault(); // Cegah kirim kalau kosong
        Toast.show('Please fill in all fields.', 'error'); 
        return;
      }

      // Kasih efek loading di tombol
      const btn = document.getElementById('submitBtn');
      btn.textContent = 'Authenticating...';
      btn.disabled = true;
      btn.style.opacity = '0.7';
    });
  </script>
  <div id="forgotModal" style="position:fixed;inset:0;background:rgba(21,30,45,.6);display:flex;align-items:center;justify-content:center;z-index:300;opacity:0;pointer-events:none;transition:opacity .25s;">
    <div id="forgotCard" style="background:white;border-radius:16px;padding:36px;max-width:400px;width:calc(100% - 32px);box-shadow:15px 15px 0 rgba(175,180,185,.8);transform:translateY(16px);transition:transform .25s;">
      <h2 style="font-size:18px;margin-bottom:8px;">🔑 Reset Password</h2>
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
<script>
  document.querySelector('.btn-sso')?.addEventListener('click', () => {
    Toast.show('University SSO is not configured for this demo environment.', 'info', 4000);
  });
</script>
</body>
</html>