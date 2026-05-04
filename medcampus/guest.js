/**
 * MedCampus — guest.js
 * Handles: login.html, register.html, index.html
 *
 * Login logic utama ada di <script> inline di login.html (perlu akses
 * variabel `cfg` dan `role` yang sudah di-set di sana).
 * File ini menangani: register form, password strength, landing page.
 */

document.addEventListener('DOMContentLoaded', () => {

  // ─── Redirect jika sudah login ────────────────────────────────────────────
  // Kalau user buka login/register tapi sudah punya sesi, langsung redirect
  if (document.getElementById('loginForm') || document.getElementById('registerForm')) {
    const session = AppData.getSession?.();
    if (session) {
      const dest = session.role === 'Doctor' ? 'doctor-dashboard.html'
                 : session.role === 'Admin'  ? 'admin-dashboard.html'
                 : 'dashboard.html';
      // Hanya redirect kalau bukan admin yang sengaja buka /login?role=admin
      const role = new URLSearchParams(window.location.search).get('role');
      if (!role || role.toLowerCase() !== 'admin' || session.role !== 'Admin') {
        window.location.href = dest;
        return;
      }
    }
  }

  // ─── REGISTER FORM ─────────────────────────────────────────────────────────
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {

    // Password strength bar
    const pwInput = document.getElementById('password');
    if (pwInput) {
      const bar = document.createElement('div');
      bar.id = 'pw-strength';
      bar.style.cssText = 'height:4px;border-radius:4px;margin-top:6px;transition:all .3s;background:var(--border);width:0;';
      pwInput.closest('.input-wrapper').insertAdjacentElement('afterend', bar);

      pwInput.addEventListener('input', () => {
        const v = pwInput.value;
        let score = 0;
        if (v.length >= 8)             score++;
        if (/[A-Z]/.test(v))           score++;
        if (/[0-9]/.test(v))           score++;
        if (/[^A-Za-z0-9]/.test(v))    score++;
        const colors = ['#ef4444','#f97316','#eab308','#529b2e'];
        const widths  = ['25%','50%','75%','100%'];
        bar.style.background = score > 0 ? colors[score-1] : 'var(--border)';
        bar.style.width      = score > 0 ? widths[score-1] : '0';
      });
    }

    registerForm.addEventListener('submit', e => {
      e.preventDefault();

      const firstname = document.getElementById('firstname').value.trim();
      const lastname  = document.getElementById('lastname').value.trim();
      const uniId     = document.getElementById('uni_id').value.trim();
      const email     = document.getElementById('reg_email').value.trim();
      const password  = document.getElementById('password').value;
      const terms     = registerForm.querySelector('input[type="checkbox"]');

      // Validasi
      if (!firstname || !lastname) { Toast.show('Please enter your full name.', 'error');  return; }
      if (!uniId)                  { Toast.show('University ID is required.', 'error');     return; }
      if (!email)                  { Toast.show('Email is required.', 'error');              return; }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { Toast.show('Enter a valid email.', 'error'); return; }
      if (password.length < 6)     { Toast.show('Password must be at least 6 characters.', 'error'); return; }
      if (!terms.checked)          { Toast.show('Please agree to the Terms of Service.', 'warning'); return; }

      const btn = registerForm.querySelector('.btn-submit');
      btn.textContent = 'Creating Account…'; btn.disabled = true;

      setTimeout(() => {
        const result = AppData.register({
          name:  firstname + ' ' + lastname,
          email, uniId
        }, password);

        if (!result.ok) {
          Toast.show(result.reason, 'error');
          btn.textContent = 'Create Account'; btn.disabled = false;
          return;
        }

        Toast.show(`Account created! Welcome, ${result.user.name}. Please sign in.`, 'success');
        setTimeout(() => { window.location.href = 'login.html'; }, 1500);
      }, 800);
    });
  }

  // ─── LANDING PAGE: smooth scroll ─────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });

  // ─── HEADER scroll shadow ─────────────────────────────────────────────────
  const header = document.querySelector('header');
  if (header) {
    window.addEventListener('scroll', () => {
      header.style.boxShadow = window.scrollY > 10 ? '0 2px 12px rgba(0,0,0,0.08)' : '';
    });
  }

  // ─── Password toggle (icon-right) ─────────────────────────────────────────
  initPasswordToggle();

});
