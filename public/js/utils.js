/**
 * MedCampus - Shared Utility Functions
 * Used across all actor roles: Guest, Patient, Doctor, Admin
 */

// ─── TOAST NOTIFICATION ────────────────────────────────────────────────────
const Toast = {
  container: null,

  init() {
    if (this.container) return;
    this.container = document.createElement('div');
    this.container.id = 'toast-container';
    this.container.style.cssText = `
      position:fixed; top:24px; right:24px; z-index:9999;
      display:flex; flex-direction:column; gap:10px; pointer-events:none;
    `;
    document.body.appendChild(this.container);
  },

  show(message, type = 'success', duration = 3000) {
    this.init();
    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
    const colors = {
      success: '#529b2e', error: '#ef4444',
      warning: '#d97706', info: '#3b82f6'
    };

    const toast = document.createElement('div');
    toast.style.cssText = `
      background:#fff; border-left:4px solid ${colors[type]};
      padding:14px 18px; border-radius:8px; font-size:14px; font-weight:500;
      box-shadow:0 4px 12px rgba(0,0,0,0.12); display:flex; align-items:center;
      gap:10px; max-width:340px; pointer-events:auto;
      animation:slideIn .3s ease; color:#151e2d;
    `;
    toast.innerHTML = `<span>${icons[type]}</span><span>${message}</span>`;

    if (!document.getElementById('toast-style')) {
      const s = document.createElement('style');
      s.id = 'toast-style';
      s.textContent = `
        @keyframes slideIn{from{transform:translateX(110%);opacity:0}to{transform:translateX(0);opacity:1}}
        @keyframes slideOut{from{transform:translateX(0);opacity:1}to{transform:translateX(110%);opacity:0}}
      `;
      document.head.appendChild(s);
    }

    this.container.appendChild(toast);
    setTimeout(() => {
      toast.style.animation = 'slideOut .3s ease forwards';
      setTimeout(() => toast.remove(), 300);
    }, duration);
  }
};

// ─── MODAL HELPER ───────────────────────────────────────────────────────────
const Modal = {
  open(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add('active');
  },
  close(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('active');
  },
  closeOnBackdrop(id) {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('click', (e) => {
        if (e.target === el) this.close(id);
      });
    }
  }
};

// ─── FORM VALIDATION ────────────────────────────────────────────────────────
const Validator = {
  email(val) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val); },
  required(val) { return val.trim() !== ''; },
  minLength(val, n) { return val.trim().length >= n; },

  highlightField(input, valid, msg = '') {
    input.style.borderColor = valid ? '' : '#ef4444';
    let hint = input.parentElement.querySelector('.field-error');
    if (!valid) {
      if (!hint) {
        hint = document.createElement('p');
        hint.className = 'field-error';
        hint.style.cssText = 'color:#ef4444;font-size:11px;margin-top:4px;';
        input.parentElement.appendChild(hint);
      }
      hint.textContent = msg;
    } else if (hint) hint.remove();
    return valid;
  },

  form(formEl) {
    let valid = true;
    formEl.querySelectorAll('[required]').forEach(input => {
      if (!this.required(input.value)) {
        this.highlightField(input, false, 'This field is required.');
        valid = false;
      } else if (input.type === 'email' && !this.email(input.value)) {
        this.highlightField(input, false, 'Enter a valid email address.');
        valid = false;
      } else {
        this.highlightField(input, true);
      }
    });
    return valid;
  }
};

// ─── ACTIVE NAV LINK ────────────────────────────────────────────────────────
function setActiveNav() {
  const current = location.pathname.split('/').pop();
  document.querySelectorAll('.nav-links a, .sidebar-nav a').forEach(a => {
    const href = a.getAttribute('href');
    if (href && href !== '#' && location.pathname.includes(href.replace('.html', ''))) {
      a.classList.add('active');
    }
  });
}

// ─── SELECTION CARDS (toggle active) ───────────────────────────────────────
function initSelectionCards(selector = '.select-card') {
  document.querySelectorAll(selector).forEach(card => {
    card.addEventListener('click', () => {
      const group = card.closest('.selection-grid, .grid-3, .shift-grid');
      if (group) group.querySelectorAll(selector).forEach(c => c.classList.remove('active'));
      card.classList.add('active');
    });
  });
}

// ─── PAYMENT CARD SELECTION ─────────────────────────────────────────────────
function initPaymentCards() {
  document.querySelectorAll('.payment-card').forEach(card => {
    card.addEventListener('click', () => {
      document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));
      card.classList.add('active');
    });
  });
}

// ─── SEARCH FILTER (client-side table) ─────────────────────────────────────
function initTableSearch(inputSel, tableSel) {
  const input = document.querySelector(inputSel);
  const table = document.querySelector(tableSel);
  if (!input || !table) return;
  input.addEventListener('input', () => {
    const q = input.value.toLowerCase();
    table.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

// ─── PASSWORD TOGGLE ────────────────────────────────────────────────────────
function initPasswordToggle() {
  document.querySelectorAll('.icon-right').forEach(icon => {
    icon.style.cursor = 'pointer';
    icon.addEventListener('click', () => {
      const input = icon.closest('.input-wrapper').querySelector('input[type="password"], input[type="text"]');
      if (!input) return;
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  });
}

// ─── STATUS BADGE CLICK (admin user-edit) ──────────────────────────────────
function initStatusCards() {
  document.querySelectorAll('.status-option').forEach(card => {
    card.addEventListener('click', () => {
      document.querySelectorAll('.status-option').forEach(c => {
        c.classList.remove('selected');
      });
      card.classList.add('selected');
    });
  });
}

// ─── AUTO-INIT ON DOM READY ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  setActiveNav();
  initSelectionCards();
  initPaymentCards();
  initPasswordToggle();
  initStatusCards();
});
