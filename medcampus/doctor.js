/**
 * MedCampus — doctor.js
 * Shared behaviour untuk semua halaman dokter.
 */

document.addEventListener('DOMContentLoaded', () => {

  // ─── AUTH GUARD + SESSION ─────────────────────────────────────────────────
  const session = window.AppData?.getSession?.();

  if (!session) {
    window.location.href = 'login.html?role=doctor';
    return;
  }
  if (session.role !== 'Doctor') {
    Toast.show(`Access denied. Redirecting to the correct portal…`, 'warning');
    const dest = session.role === 'Admin' ? 'login.html?role=admin' : 'login.html';
    setTimeout(() => { window.location.href = dest; }, 1500);
    return;
  }

  // Update nama di semua .profile-name
  document.querySelectorAll('.profile-name').forEach(el => {
    if (el.textContent.includes('⌄')) el.textContent = session.name + ' ⌄';
  });
  // Update greeting di dashboard
  const greeting = document.querySelector('h1');
  if (greeting && greeting.textContent.includes('Good Morning')) {
    const hour = new Date().getHours();
    const tod  = hour < 12 ? 'Good Morning' : hour < 17 ? 'Good Afternoon' : 'Good Evening';
    greeting.textContent = `${tod}, ${session.name}`;
  }

  // ─── LOGOUT ───────────────────────────────────────────────────────────────
  document.querySelectorAll('[data-action="logout"]').forEach(btn => {
    btn.addEventListener('click', () => {
      AppData.logout();
      window.location.href = 'login.html?role=doctor';
    });
  });

  // ─── NAVBAR SEARCH (global table filter) ─────────────────────────────────
  const navSearch = document.querySelector('.nav-left .search-bar input');
  if (navSearch && document.querySelector('tbody')) {
    navSearch.addEventListener('input', () => {
      const q = navSearch.value.toLowerCase();
      document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  }

  // ─── SCHEDULE: WEEK NAVIGATION ────────────────────────────────────────────
  const weekLabel = document.getElementById('weekLabel');
  const prevWeek  = document.getElementById('prevWeek');
  const nextWeek  = document.getElementById('nextWeek');

  if (weekLabel && prevWeek && nextWeek) {
    const baseStart = new Date('2026-10-21');
    let offset = 0;

    function fmtWeek(start) {
      const end = new Date(start);
      end.setDate(end.getDate() + 4);
      const opts = { month: 'long', day: 'numeric' };
      return `${start.toLocaleDateString('en-US', opts)} – ${end.toLocaleDateString('en-US', { day: 'numeric' })}, ${end.getFullYear()}`;
    }

    prevWeek.addEventListener('click', () => {
      offset--;
      const d = new Date(baseStart.getTime() + offset * 7 * 86400000);
      weekLabel.textContent = fmtWeek(d);
    });
    nextWeek.addEventListener('click', () => {
      offset++;
      const d = new Date(baseStart.getTime() + offset * 7 * 86400000);
      weekLabel.textContent = fmtWeek(d);
    });
  }

  // ─── PRINT CLEANUP ────────────────────────────────────────────────────────
  document.querySelectorAll('[onclick="window.print()"]').forEach(btn => {
    btn.removeAttribute('onclick');
    btn.addEventListener('click', () => window.print());
  });

  // ─── PROFILE DROPDOWN ─────────────────────────────────────────────────────
  const profileDD = document.querySelector('.profile-dropdown');
  if (profileDD) {
    profileDD.addEventListener('click', () => profileDD.classList.toggle('open'));
    document.addEventListener('click', e => {
      if (!profileDD.contains(e.target)) profileDD.classList.remove('open');
    });
  }

});
