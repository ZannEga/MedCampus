document.addEventListener('DOMContentLoaded', () => {

  // ─── Redirect jika sudah login ────────────────────────────────────────────
  if (document.getElementById('loginForm') || document.getElementById('registerForm')) {
    // Logic ini tetap dibiarkan untuk keamanan sisi client
  }

  // ─── REGISTER FORM (UI ONLY) ──────────────────────────────────────────────
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    const pwInput = document.getElementById('password');
    if (pwInput) {
      const bar = document.createElement('div');
      bar.id = 'pw-strength';
      bar.style.cssText = 'height:4px;border-radius:4px;margin-top:6px;transition:all .3s;background:var(--border);width:0;';
      pwInput.closest('.input-wrapper').insertAdjacentElement('afterend', bar);

      pwInput.addEventListener('input', () => {
        const v = pwInput.value;
        let score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        const colors = ['#ef4444','#f97316','#eab308','#529b2e'];
        const widths  = ['25%','50%','75%','100%'];
        bar.style.background = score > 0 ? colors[score-1] : 'var(--border)';
        bar.style.width      = score > 0 ? widths[score-1] : '0';
      });
    }
    // Penutup block if (registerForm) yang tadi hilang:
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

});