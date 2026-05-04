/**
 * MedCampus — patient.js
 * Shared behaviour untuk semua halaman pasien.
 */

document.addEventListener('DOMContentLoaded', () => {

  // ─── AUTH GUARD + SESSION ─────────────────────────────────────────────────
  const session = window.AppData?.getSession?.();
  const publicPages = ['login.html', 'register.html', 'index.html'];
  const page = location.pathname.split('/').pop() || 'index.html';

  if (!session && !publicPages.includes(page)) {
    window.location.href = 'login.html';
    return;
  }

  if (session) {
    // Update nama di semua profile-name
    document.querySelectorAll('.profile-name').forEach(el => {
      if (el.textContent.includes('⌄')) el.textContent = session.name + ' ⌄';
    });
    // Dashboard welcome
    const welcome = document.getElementById('dash-welcome');
    if (welcome) welcome.textContent = 'Welcome, ' + session.name;
    // Ticket patient name
    const tkName = document.getElementById('tk-patient-name');
    if (tkName) tkName.textContent = session.name;
  }

  // ─── LOGOUT ───────────────────────────────────────────────────────────────
  document.querySelectorAll('[data-action="logout"]').forEach(btn => {
    btn.addEventListener('click', () => {
      AppData.logout();
      window.location.href = 'login.html';
    });
  });

  // ─── CANCEL MODAL (only on pages that have it) ────────────────────────────
  window.openCancelModal  = () => Modal.open('cancelModal');
  window.closeCancelModal = () => Modal.close('cancelModal');
  window.confirmCancel = () => {
    Toast.show('Appointment cancelled successfully.', 'info');
    closeCancelModal();
    if (window.AppData) AppData.clearQueue?.();
    setTimeout(() => { window.location.href = 'dashboard.html'; }, 1200);
  };
  // Only wire backdrop if modal exists on this page
  if (document.getElementById('cancelModal')) {
    Modal.closeOnBackdrop('cancelModal');
  }

  // ─── LIVE QUEUE PROGRESS (queue-detail.html) ──────────────────────────────
  const progressFill  = document.querySelector('.progress-fill');
  const queueAheadEl  = document.querySelector('.queue-ahead-count');
  const progressLabel = document.getElementById('progressLabel');

  if (progressFill) {
    let progress = parseFloat(progressFill.style.width) || 0;
    let ahead    = parseInt((queueAheadEl?.textContent || '').match(/\d+/)?.[0] ?? 0);

    const tick = setInterval(() => {
      if (progress >= 100) {
        clearInterval(tick);
        Toast.show("It's your turn! Please proceed to the clinic.", 'success', 6000);
        if (queueAheadEl)  queueAheadEl.textContent = '0 people ahead of you';
        if (progressLabel) progressLabel.textContent = '100% Complete';
        return;
      }
      progress = Math.min(100, progress + (Math.random() * 3));
      progressFill.style.width = progress.toFixed(1) + '%';
      if (progressLabel) progressLabel.textContent = Math.round(progress) + '% Complete';

      const newAhead = Math.max(0, Math.floor((100 - progress) / 8));
      if (newAhead < ahead) {
        ahead = newAhead;
        if (queueAheadEl) queueAheadEl.textContent =
          `${ahead} ${ahead === 1 ? 'person' : 'people'} ahead of you`;
        if (ahead > 0) Toast.show(`Queue updated: ${ahead} person(s) ahead of you.`, 'info', 2500);
      }
    }, 8000);
  }

  // ─── PAYMENT CARD SELECTION ───────────────────────────────────────────────
  initPaymentCards();

  // ─── PRINT BUTTON CLEANUP ─────────────────────────────────────────────────
  document.querySelectorAll('[onclick="window.print()"]').forEach(btn => {
    btn.removeAttribute('onclick');
    btn.addEventListener('click', () => window.print());
  });

});
