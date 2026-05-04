/**
 * MedCampus — mobile-nav.js
 * Injects hamburger button + slide-in drawer untuk navbar
 * dokter dan pasien di mobile view (≤768px).
 *
 * Tidak mengubah HTML yang sudah ada — semua elemen di-inject via JS.
 */

(function () {

  // ── Config per role ────────────────────────────────────────────────────────
  const IS_DOCTOR  = !!document.querySelector('.nav-left');
  const PROFILE_HREF = IS_DOCTOR ? 'doctor-profile.html' : 'patient-profile.html';
  const LOGIN_HREF   = IS_DOCTOR ? 'login.html?role=doctor' : 'login.html';

  // Nav links definition (matched to what's in the navbar)
  const DOCTOR_LINKS = [
    { href: 'doctor-dashboard.html', label: 'Dashboard', icon: '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>' },
    { href: 'doctor-patients.html',  label: "Today's Patients", icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>' },
    { href: 'doctor-records.html',   label: 'Medical Records', icon: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>' },
    { href: 'doctor-schedule.html',  label: 'Schedule', icon: '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>' },
  ];

  const PATIENT_LINKS = [
    { href: 'dashboard.html',    label: 'Home', icon: '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>' },
    { href: 'booking.html',      label: 'Book Appointment', icon: '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>' },
    { href: 'history.html',      label: 'Medical History', icon: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline>' },
    { href: 'service-guide.html',label: 'Service Guide', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>' },
  ];

  const LINKS = IS_DOCTOR ? DOCTOR_LINKS : PATIENT_LINKS;

  // ── Detect current page ────────────────────────────────────────────────────
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';

  // ── Get session & avatar ───────────────────────────────────────────────────
  function getSession() {
    try { return JSON.parse(localStorage.getItem('mc_session')); } catch { return null; }
  }
  function getAvatar(session) {
    if (window.AppData) {
      const users = AppData.getUsers?.() || [];
      const user  = users.find(u => u.id === session?.userId);
      if (user?.avatar) return user.avatar;
    }
    const init  = (session?.name || 'U').split(' ').filter(Boolean).map(w => w[0]).slice(0, 2).join('');
    const color = IS_DOCTOR ? 'a7c4a0' : 'fca5a5';
    return `https://placehold.co/42x42/${color}/ffffff?text=${init}`;
  }

  // ── Build SVG icon ─────────────────────────────────────────────────────────
  function icon(path) {
    return `<svg viewBox="0 0 24 24">${path}</svg>`;
  }

  // ── Build and inject DOM ───────────────────────────────────────────────────
  function buildMobileNav() {
    const navbar      = document.querySelector('.navbar');
    const navContainer = document.querySelector('.nav-container');
    const navProfile  = document.querySelector('.nav-profile');
    if (!navbar || !navContainer || !navProfile) return;

    const session   = getSession();
    const avatarSrc = getAvatar(session);
    const name      = session?.name  || '—';
    const role      = session?.role  || '';
    const email     = session?.email || '';

    // ── 1. Hamburger button (inject into nav-profile) ──────────────────────
    const hamburger = document.createElement('button');
    hamburger.className   = 'hamburger-btn';
    hamburger.setAttribute('aria-label', 'Open menu');
    hamburger.setAttribute('aria-expanded', 'false');
    hamburger.innerHTML   = '<span></span><span></span><span></span>';
    navProfile.appendChild(hamburger);

    // ── 2. Overlay ─────────────────────────────────────────────────────────
    const overlay = document.createElement('div');
    overlay.className = 'mobile-nav-overlay';
    overlay.style.display = 'none';
    document.body.appendChild(overlay);

    // ── 3. Drawer ──────────────────────────────────────────────────────────
    const drawer = document.createElement('div');
    drawer.className = 'mobile-nav-drawer';

    // Header
    const drawerHeader = document.createElement('div');
    drawerHeader.className = 'mobile-drawer-header';
    drawerHeader.innerHTML = `
      <div class="nav-logo">
        <svg viewBox="0 0 24 24" width="22" style="fill:var(--primary-green)"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <button class="mobile-drawer-close" aria-label="Close menu">✕</button>`;

    // User info
    const userInfo = document.createElement('div');
    userInfo.className = 'mobile-drawer-user';
    userInfo.innerHTML = `
      <div class="du-avatar"><img src="${avatarSrc}" alt="Avatar"></div>
      <div>
        <h4>${name}</h4>
        <p>${role}${email ? ' • ' + email : ''}</p>
      </div>`;

    // Search (doctor only)
    let searchEl = null;
    if (IS_DOCTOR) {
      searchEl = document.createElement('div');
      searchEl.className = 'mobile-drawer-search';
      searchEl.innerHTML = `
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" placeholder="Search patients…">`;
    }

    // Nav links
    const linksEl = document.createElement('div');
    linksEl.className = 'mobile-drawer-links';

    LINKS.forEach(({ href, label }) => {
      const a = document.createElement('a');
      a.href      = href;
      a.innerHTML = `${icon('<line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line>')} ${label}`;
      if (href === currentPage) a.classList.add('active');
      linksEl.appendChild(a);
    });

    // Divider
    const div1 = document.createElement('div');
    div1.className = 'mobile-drawer-divider';
    linksEl.appendChild(div1);

    // My Profile
    const profileLink = document.createElement('a');
    profileLink.href      = PROFILE_HREF;
    profileLink.innerHTML = `${icon('<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>')} My Profile`;
    if (PROFILE_HREF === currentPage) profileLink.classList.add('active');
    linksEl.appendChild(profileLink);

    // Preferences
    const prefLink = document.createElement('a');
    prefLink.href      = `${PROFILE_HREF}?tab=preferences`;
    prefLink.innerHTML = `${icon('<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-2.82 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>')} Preferences`;
    linksEl.appendChild(prefLink);

    // Divider
    const div2 = document.createElement('div');
    div2.className = 'mobile-drawer-divider';
    linksEl.appendChild(div2);

    // Logout
    const logoutBtn = document.createElement('button');
    logoutBtn.className = 'danger';
    logoutBtn.innerHTML = `${icon('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>')} Logout`;
    logoutBtn.addEventListener('click', () => {
      window.AppData?.logout?.();
      window.location.href = LOGIN_HREF;
    });
    linksEl.appendChild(logoutBtn);

    // Assemble drawer
    drawer.appendChild(drawerHeader);
    drawer.appendChild(userInfo);
    if (searchEl) drawer.appendChild(searchEl);
    drawer.appendChild(linksEl);
    document.body.appendChild(drawer);

    // ── 4. Open / Close logic ──────────────────────────────────────────────
    function openDrawer() {
      overlay.style.display = 'block';
      requestAnimationFrame(() => overlay.classList.add('visible'));
      drawer.classList.add('open');
      hamburger.classList.add('open');
      hamburger.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      overlay.classList.remove('visible');
      drawer.classList.remove('open');
      hamburger.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      setTimeout(() => { overlay.style.display = 'none'; }, 260);
    }

    hamburger.addEventListener('click', openDrawer);
    overlay.addEventListener('click', closeDrawer);
    drawerHeader.querySelector('.mobile-drawer-close').addEventListener('click', closeDrawer);

    // Close on Escape key
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && drawer.classList.contains('open')) closeDrawer();
    });

    // Close when a nav link is clicked (navigating away)
    drawer.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', closeDrawer);
    });

    // ── 5. Sync drawer search with table (doctor only) ─────────────────────
    if (searchEl) {
      searchEl.querySelector('input').addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
          row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
        // Also sync desktop search bar
        const desktopSearch = document.querySelector('.nav-left .search-bar input');
        if (desktopSearch) desktopSearch.value = e.target.value;
      });
    }

    // ── 6. Close drawer if resized back to desktop ─────────────────────────
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768 && drawer.classList.contains('open')) {
        closeDrawer();
      }
    });
  }

  // Run after DOM and session are ready
  document.addEventListener('DOMContentLoaded', buildMobileNav);

})();
