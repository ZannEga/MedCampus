/**
 * MedCampus — app-data.js
 * Satu sumber data mock untuk semua halaman.
 * Pakai localStorage sebagai jembatan antar halaman.
 */

// ─── MOCK DATA ────────────────────────────────────────────────────────────────

const MOCK_VISITS = [
  {
    id: 'MC-20261012',
    status: 'completed',
    clinic: 'General Clinic',
    doctor: 'Dr. Andi Wijaya',
    date: 'October 12, 2026',
    time: '09:30 AM',
    diagnosis: 'Common Cold (Upper Respiratory Tract Infection)',
    diagnosisDetail: 'Patient presented with symptoms including a sore throat, mild nasal congestion, and a low-grade fever. Physical examination revealed mild pharyngeal erythema. Vitals are stable.',
    advice: [
      'Increase fluid intake (at least 8–10 glasses of water per day).',
      'Get plenty of rest for the next 48 hours.',
      'Gargle with warm salt water to relieve throat discomfort.'
    ],
    medicines: [
      { name: 'Paracetamol', desc: 'Analgesic & Antipyretic', dose: '500mg', freq: '3× daily, after meals', duration: '5 Days' },
      { name: 'Vitamin C',   desc: 'Supplement',              dose: '500mg', freq: 'Once daily, morning',  duration: '10 Days' }
    ],
    clinic_address: 'Jl. Mulyorejo Utara No. 201, Bldg B, Floor 2',
    clinic_phone: '+62 8127790926',
    clinic_hours: 'Mon – Fri, 8:00 AM – 6:00 PM'
  },
  {
    id: 'MC-20260910',
    status: 'cancelled',
    clinic: 'General Clinic',
    doctor: 'Dr. Andi Wijaya',
    date: 'September 10, 2026',
    time: '11:00 AM',
    cancelReason: 'Patient unable to attend (Reschedule).',
    diagnosis: null,
    medicines: []
  }
];

const MOCK_QUEUE = {
  number: 'A-12',
  appointmentId: 'MC-88291',
  clinic: 'General Clinic',
  doctor: 'Dr. Sarah Jenkins',
  specialty: 'Senior Practitioner',
  date: 'Friday, October 6, 2026',
  time: '09:00 – 10:00 WIB',
  estimatedTime: '10:30 AM',
  status: 'Waiting',
  progress: 85,
  aheadCount: 2,
  patientName: 'Budi Santoso',
  patientId: '12345678',
  clinic_address: '123 Medical Plaza, East Side',
  fee: 'Rp 165.000'
};

const MOCK_PATIENTS = [
  { queue: 'A-12', name: 'John Smith',    gender: 'Male',   age: 34, time: '09:00 AM', type: 'Follow-up',    status: 'waiting',      id: 'PT-001' },
  { queue: 'A-13', name: 'Emily Davis',   gender: 'Female', age: 28, time: '09:30 AM', type: 'Consultation', status: 'waiting',      id: 'PT-002' },
  { queue: 'A-14', name: 'Robert Wilson', gender: 'Male',   age: 45, time: '10:00 AM', type: 'Urgent Visit', status: 'in-progress',  id: 'PT-003' },
  { queue: 'A-15', name: 'Sarah Brown',   gender: 'Female', age: 52, time: '10:30 AM', type: 'Follow-up',    status: 'waiting',      id: 'PT-004' },
];

const MOCK_RECORDS = [
  {
    patientId: 'PT-8821',
    name: 'John Doe',
    dob: '14 May 1984',
    gender: 'Male',
    blood: 'A+',
    lastVisit: 'Oct 12, 2026',
    statusLabel: 'Stable',
    history: [
      {
        date: 'October 12, 2026',
        doctor: 'Dr. Sarah Wilson',
        type: 'General Checkup',
        diagnosis: 'Mild hypertension observed during routine evaluation. Stress-related factors identified.',
        medicines: ['Lisinopril 10mg (Daily)', 'Magnesium Supplement 250mg']
      },
      {
        date: 'June 24, 2026',
        doctor: 'Dr. Robert Chen',
        type: 'Specialist Consultation',
        diagnosis: 'Seasonal allergic rhinitis. Symptoms include nasal congestion and ocular itching.',
        medicines: ['Cetirizine 10mg (As needed)', 'Fluticasone Propionate spray']
      }
    ]
  },
  {
    patientId: 'PT-7742',
    name: 'Jane Smith',
    dob: '03 March 1995',
    gender: 'Female',
    blood: 'B+',
    lastVisit: 'Nov 05, 2026',
    statusLabel: 'Follow-up',
    history: [
      {
        date: 'November 5, 2026',
        doctor: 'Dr. Sarah Wilson',
        type: 'Follow-up',
        diagnosis: 'Post-viral fatigue syndrome. Recovering well from previous URI.',
        medicines: ['Vitamin B Complex (Daily)', 'Iron Supplement 65mg']
      }
    ]
  }
];

// ─── STORAGE HELPERS ─────────────────────────────────────────────────────────

const AppData = {
  // Visit detail
  setVisit(visitId) {
    const visit = MOCK_VISITS.find(v => v.id === visitId);
    if (visit) localStorage.setItem('mc_selected_visit', JSON.stringify(visit));
  },
  getVisit() {
    try { return JSON.parse(localStorage.getItem('mc_selected_visit')); } catch { return null; }
  },

  // Queue / active appointment
  setQueue(data) {
    localStorage.setItem('mc_active_queue', JSON.stringify(data || MOCK_QUEUE));
  },
  getQueue() {
    try {
      const stored = localStorage.getItem('mc_active_queue');
      return stored ? JSON.parse(stored) : MOCK_QUEUE;
    } catch { return MOCK_QUEUE; }
  },

  // Current patient being examined (doctor side)
  setPatient(patient) {
    localStorage.setItem('mc_current_patient', JSON.stringify(patient));
  },
  getPatient() {
    try { return JSON.parse(localStorage.getItem('mc_current_patient')); } catch { return null; }
  },

  // Medical record selected
  setRecord(record) {
    localStorage.setItem('mc_selected_record', JSON.stringify(record));
  },
  getRecord() {
    try { return JSON.parse(localStorage.getItem('mc_selected_record')); } catch { return null; }
  },

  // Booking summary passed to checkout/success/ticket
  setBooking(data) {
    localStorage.setItem('mc_booking', JSON.stringify(data));
  },
  getBooking() {
    try {
      const stored = localStorage.getItem('mc_booking');
      return stored ? JSON.parse(stored) : null;
    } catch { return null; }
  },

  clearBooking() { localStorage.removeItem('mc_booking'); },
  clearQueue()   { localStorage.removeItem('mc_active_queue'); },
};

// expose globally
window.AppData   = AppData;
window.MOCK_VISITS   = MOCK_VISITS;
window.MOCK_QUEUE    = MOCK_QUEUE;
window.MOCK_PATIENTS = MOCK_PATIENTS;
window.MOCK_RECORDS  = MOCK_RECORDS;

// ─── MOCK USERS (admin kelola) ────────────────────────────────────────────────

const MOCK_USERS = [
  {
    id: 'USR-001',
    name: 'Dr. Sarah Jenkins',
    initials: 'SJ',
    email: 's.jenkins@medcampus.edu',
    phone: '+62 812 1111 2222',
    role: 'Doctor',
    department: 'General Medicine',
    idNumber: 'MC-2024-8841',
    status: 'active',
    lastUpdated: 'Oct 24, 2026 • 11:24 AM',
    avatar: 'https://placehold.co/40x40/a7c4a0/ffffff?text=SJ'
  },
  {
    id: 'USR-002',
    name: 'Marcus Thorne',
    initials: 'MT',
    email: 'm.thorne@student.med.edu',
    phone: '+62 812 3333 4444',
    role: 'Student',
    department: 'None (Student / Admin)',
    idNumber: 'ST-882-9901',
    status: 'offline',
    lastUpdated: 'Oct 20, 2026 • 09:00 AM',
    avatar: 'https://placehold.co/40x40/cbd5e1/ffffff?text=MT'
  },
  {
    id: 'USR-003',
    name: 'Dr. Alan Turing',
    initials: 'AT',
    email: 'a.turing@medcampus.edu',
    phone: '+62 812 5555 6666',
    role: 'Doctor',
    department: 'Dental Clinic',
    idNumber: 'MC-2024-0012',
    status: 'suspended',
    lastUpdated: 'Oct 18, 2026 • 03:15 PM',
    avatar: 'https://placehold.co/40x40/cbd5e1/ffffff?text=AT'
  },
  {
    id: 'USR-004',
    name: 'Dr. Emily Watson',
    initials: 'EW',
    email: 'e.watson@medcampus.edu',
    phone: '+62 812 7777 8888',
    role: 'Doctor',
    department: 'General Medicine',
    idNumber: 'MC-2024-0058',
    status: 'active',
    lastUpdated: 'Oct 24, 2026 • 08:00 AM',
    avatar: 'https://placehold.co/40x40/a7c4a0/ffffff?text=EW'
  },
  {
    id: 'USR-005',
    name: 'Budi Santoso',
    initials: 'BS',
    email: 'b.santoso@student.med.edu',
    phone: '+62 812 9999 0000',
    role: 'Student',
    department: 'None (Student / Admin)',
    idNumber: 'ST-123-4567',
    status: 'active',
    lastUpdated: 'Oct 23, 2026 • 02:00 PM',
    avatar: 'https://placehold.co/40x40/cbd5e1/ffffff?text=BS'
  }
];

// Simpan/ambil daftar user (dengan support tambah/edit/suspend)
AppData.getUsers = function() {
  try {
    const stored = localStorage.getItem('mc_admin_users');
    return stored ? JSON.parse(stored) : MOCK_USERS;
  } catch { return MOCK_USERS; }
};

AppData.saveUsers = function(users) {
  localStorage.setItem('mc_admin_users', JSON.stringify(users));
};

AppData.setSelectedUser = function(user) {
  localStorage.setItem('mc_admin_selected_user', JSON.stringify(user));
};

AppData.getSelectedUser = function() {
  try { return JSON.parse(localStorage.getItem('mc_admin_selected_user')); }
  catch { return null; }
};

window.MOCK_USERS = MOCK_USERS;

// ─── MOCK MEDICINES ───────────────────────────────────────────────────────────
const MOCK_MEDICINES = [
  {
    id: 'MED-001', name: 'Amoxicillin 500mg', category: 'Antibiotics',
    sku: 'AMX-500-2023', unit: 'Pills', stock: 450,
    status: 'in_stock', description: 'Broad-spectrum antibiotic for bacterial infections.',
    color: 'green'
  },
  {
    id: 'MED-002', name: 'Paracetamol 650mg', category: 'Analgesics',
    sku: 'PAR-650-2023', unit: 'Pills', stock: 12,
    status: 'low_stock', description: 'Analgesic and antipyretic for pain and fever relief.',
    color: 'orange'
  },
  {
    id: 'MED-003', name: 'Insulin Glargine', category: 'Antidiabetics',
    sku: 'INS-GL-2023', unit: 'Bottles', stock: 0,
    status: 'out_of_stock', description: 'Long-acting insulin analog for diabetes management.',
    color: 'red'
  },
  {
    id: 'MED-004', name: 'Vitamin C 500mg', category: 'Vitamins',
    sku: 'VTC-500-2023', unit: 'Pills', stock: 320,
    status: 'in_stock', description: 'Ascorbic acid supplement for immune support.',
    color: 'green'
  },
  {
    id: 'MED-005', name: 'Cetirizine 10mg', category: 'Antihistamines',
    sku: 'CTZ-010-2023', unit: 'Pills', stock: 8,
    status: 'low_stock', description: 'Second-generation antihistamine for allergy relief.',
    color: 'orange'
  },
  {
    id: 'MED-006', name: 'Omeprazole 20mg', category: 'Antacids',
    sku: 'OMP-020-2023', unit: 'Capsules', stock: 200,
    status: 'in_stock', description: 'Proton pump inhibitor for acid reflux and ulcers.',
    color: 'green'
  }
];

AppData.getMedicines = function() {
  try {
    const s = localStorage.getItem('mc_admin_medicines');
    return s ? JSON.parse(s) : MOCK_MEDICINES;
  } catch { return MOCK_MEDICINES; }
};
AppData.saveMedicines = function(list) {
  localStorage.setItem('mc_admin_medicines', JSON.stringify(list));
};
AppData.setSelectedMedicine = function(med) {
  localStorage.setItem('mc_admin_selected_medicine', JSON.stringify(med));
};
AppData.getSelectedMedicine = function() {
  try { return JSON.parse(localStorage.getItem('mc_admin_selected_medicine')); }
  catch { return null; }
};

window.MOCK_MEDICINES = MOCK_MEDICINES;

// ─── MOCK SCHEDULES ───────────────────────────────────────────────────────────
const MOCK_SCHEDULES = [
  {
    id: 'SCH-001',
    doctor: 'Dr. Sarah Jenkins', doctorId: 'MED-9021', initials: 'SJ',
    department: 'Cardiology', shift: 'Morning', shiftTime: '08:00 – 14:00',
    room: 'Room 302, Wing B', date: '2026-10-16', status: 'active',
    notes: ''
  },
  {
    id: 'SCH-002',
    doctor: 'Dr. Michael Chen', doctorId: 'MED-4412', initials: 'MC',
    department: 'Neurology', shift: 'Afternoon', shiftTime: '14:00 – 20:00',
    room: 'Room 110, Wing A', date: '2026-10-16', status: 'active',
    notes: ''
  },
  {
    id: 'SCH-003',
    doctor: 'Dr. Emily Watson', doctorId: 'MED-7731', initials: 'EW',
    department: 'Pediatrics', shift: 'Morning', shiftTime: '08:00 – 12:00',
    room: 'Room 405, Wing C', date: '2026-10-16', status: 'leave',
    notes: 'On annual leave.'
  },
  {
    id: 'SCH-004',
    doctor: 'Dr. Robert Miller', doctorId: 'MED-5501', initials: 'RM',
    department: 'General Medicine', shift: 'Morning', shiftTime: '07:00 – 15:00',
    room: 'OPD Room 1', date: '2026-10-16', status: 'active',
    notes: ''
  }
];

AppData.getSchedules = function() {
  try {
    const s = localStorage.getItem('mc_admin_schedules');
    return s ? JSON.parse(s) : MOCK_SCHEDULES;
  } catch { return MOCK_SCHEDULES; }
};
AppData.saveSchedules = function(list) {
  localStorage.setItem('mc_admin_schedules', JSON.stringify(list));
};
AppData.setSelectedSchedule = function(sch) {
  localStorage.setItem('mc_admin_selected_schedule', JSON.stringify(sch));
};
AppData.getSelectedSchedule = function() {
  try { return JSON.parse(localStorage.getItem('mc_admin_selected_schedule')); }
  catch { return null; }
};

window.MOCK_SCHEDULES = MOCK_SCHEDULES;

// ─── DEMO CREDENTIALS (password semua: "medcampus123") ───────────────────────
// Disimpan terpisah dari MOCK_USERS agar password tidak tampil di tabel admin
const MOCK_CREDENTIALS = [
  { email: 's.jenkins@medcampus.edu',   password: 'medcampus123', userId: 'USR-001' },
  { email: 'm.thorne@student.med.edu',  password: 'medcampus123', userId: 'USR-002' },
  { email: 'e.watson@medcampus.edu',    password: 'medcampus123', userId: 'USR-004' },
  { email: 'b.santoso@student.med.edu', password: 'medcampus123', userId: 'USR-005' },
  // Admin demo account (tidak ada di MOCK_USERS karena admin bukan pasien/dokter)
  { email: 'admin@medcampus.edu',       password: 'admin123',     userId: 'USR-ADMIN',
    _inject: { id:'USR-ADMIN', name:'Admin User', role:'Admin', status:'active',
               email:'admin@medcampus.edu', idNumber:'ADM-0001', department:'—',
               initials:'AU', avatar:'https://placehold.co/40x40/94a3b8/fff?text=AU',
               lastUpdated:'—' }
  },
];

// ─── AUTH SESSION ─────────────────────────────────────────────────────────────
AppData.login = function(email, password) {
  // 1. Cek di credentials list dulu
  const cred = MOCK_CREDENTIALS.find(
    c => c.email.toLowerCase() === email.toLowerCase() && c.password === password
  );
  if (cred) {
    let user = cred._inject || AppData.getUsers().find(u => u.id === cred.userId);
    if (!user) return { ok: false, reason: 'User data not found.' };
    if (user.status === 'suspended') return { ok: false, reason: 'Your account has been suspended. Please contact admin.' };
    localStorage.setItem('mc_session', JSON.stringify({ userId: user.id, role: user.role, name: user.name, email: user.email, loginAt: Date.now() }));
    return { ok: true, user };
  }

  // 2. Cek di localStorage users (akun yang dibuat lewat register/admin)
  const users = AppData.getUsers();
  const storedCreds = JSON.parse(localStorage.getItem('mc_stored_creds') || '[]');
  const storedCred  = storedCreds.find(c => c.email.toLowerCase() === email.toLowerCase() && c.password === password);
  if (storedCred) {
    const user = users.find(u => u.email.toLowerCase() === email.toLowerCase());
    if (!user) return { ok: false, reason: 'Account not found.' };
    if (user.status === 'suspended') return { ok: false, reason: 'Your account has been suspended.' };
    localStorage.setItem('mc_session', JSON.stringify({ userId: user.id, role: user.role, name: user.name, email: user.email, loginAt: Date.now() }));
    return { ok: true, user };
  }

  return { ok: false, reason: 'Incorrect email or password.' };
};

AppData.register = function(userData, password) {
  const users = AppData.getUsers();
  // Cek duplicate email
  const allEmails = [
    ...users.map(u => u.email.toLowerCase()),
    ...MOCK_CREDENTIALS.map(c => c.email.toLowerCase())
  ];
  if (allEmails.includes(userData.email.toLowerCase())) {
    return { ok: false, reason: 'An account with this email already exists.' };
  }

  const initials = userData.name.split(' ').filter(Boolean).map(w => w[0].toUpperCase()).slice(0,2).join('');
  const newUser = {
    id:          'USR-' + Date.now(),
    name:        userData.name,
    initials,
    email:       userData.email,
    phone:       '—',
    role:        'Student',
    department:  'None (Student / Admin)',
    idNumber:    userData.uniId || ('ST-' + Date.now().toString().slice(-6)),
    status:      'active',
    lastUpdated: new Date().toLocaleString('en-US', { month:'short', day:'numeric', year:'numeric' }),
    avatar:      `https://placehold.co/40x40/a7c4a0/ffffff?text=${initials}`
  };

  users.push(newUser);
  AppData.saveUsers(users);

  // Simpan password terpisah
  const creds = JSON.parse(localStorage.getItem('mc_stored_creds') || '[]');
  creds.push({ email: newUser.email, password });
  localStorage.setItem('mc_stored_creds', JSON.stringify(creds));

  return { ok: true, user: newUser };
};

AppData.getSession = function() {
  try { return JSON.parse(localStorage.getItem('mc_session')); }
  catch { return null; }
};

AppData.logout = function() {
  localStorage.removeItem('mc_session');
};

// Redirect ke login jika belum login (dipanggil di halaman yang butuh auth)
AppData.requireAuth = function(allowedRoles) {
  const session = AppData.getSession();
  if (!session) {
    window.location.href = 'login.html';
    return null;
  }
  if (allowedRoles && !allowedRoles.includes(session.role)) {
    Toast.show(`Access denied. This page is for ${allowedRoles.join('/')} only.`, 'error');
    setTimeout(() => { window.location.href = 'login.html'; }, 1500);
    return null;
  }
  return session;
};


// ─── VISITS PERSISTENCE (booking yang dibuat user) ────────────────────────────
AppData.getVisits = function() {
  try {
    const stored = localStorage.getItem('mc_patient_visits');
    return stored ? JSON.parse(stored) : [...MOCK_VISITS];
  } catch { return [...MOCK_VISITS]; }
};
AppData.saveVisits = function(visits) {
  localStorage.setItem('mc_patient_visits', JSON.stringify(visits));
};

window.MOCK_CREDENTIALS = MOCK_CREDENTIALS;
