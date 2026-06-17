<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical History - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </div>
      <div class="nav-links">
        <a href="{{ url('/patient/dashboard') }}">Home</a>
        <a href="{{ url('/patient/booking') }}">Book Appointment</a>
        <a href="{{ url('/patient/history') }}" class="active">Medical History</a>
      </div>
      <div class="nav-profile" style="position: relative;">
        <div class="bell-wrapper">
          <span class="bell">🔔</span>
        </div>
        
        <!-- Tombol Profil Utama -->
        <div id="mcProfileToggle" onclick="toggleDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px; margin-left:16px; border: 1px solid var(--border);">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-right: 4px;">▼</span>
        </div>

        <!-- Menu Dropdown Pop-up -->
        <div id="mcDropdownMenu" style="display: none; position: absolute; top: 115%; right: 0; background: white; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
          
          <!-- Info Singkat di dalam Dropdown -->
          <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: #f8fafc;">
             <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary-green); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
             </div>
             <div>
               <p style="margin:0; font-size:14px; font-weight:700; color: var(--dark-navy);">{{ Auth::user()->user_name }}</p>
               <p style="margin:0; font-size:12px; color:var(--text-gray);">{{ Auth::user()->id_user }}</p>
             </div>
          </div>
          
          <!-- Link Menu -->
          <a href="{{ url('/patient/profile') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: var(--dark-navy); text-decoration: none; font-size: 14px; border-bottom: 1px solid var(--border); transition: 0.2s;">
            <span>👤</span> My Profile
          </a>
          
          <!-- Tombol Logout -->
          <a href="{{ url('/logout') }}" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; border-top: 1px solid var(--border);">
            <span>🚪</span> Logout
          </a>
        </div>
      </div>

      <!-- Script Interaksi Dropdown -->
      <script>
        function toggleDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('mcDropdownMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
        
        // Auto-close jika klik sembarang tempat di layar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mcDropdownMenu');
            const toggle = document.getElementById('mcProfileToggle');
            if (menu && !menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
      </script>
    </div>
  </nav>

  <main class="main-content container">

    <!-- HEADER & DOWNLOAD REPORT -->
    <div class="flex-between" style="align-items: flex-start; margin-bottom: 24px;">
      <div>
        <h1 style="font-size: 28px; margin-bottom: 8px; color: var(--dark-navy);">Medical History</h1>
        <p style="color: var(--text-gray); font-size: 15px;">Manage and review your medical records, diagnoses, and prescriptions.</p>
      </div>
      <button class="btn btn-outline" style="background: white; border-radius: 8px; font-size: 14px; display: flex; align-items: center; gap: 8px; padding: 10px 16px;">
        <span style="color: var(--text-gray);">📥</span> Download Report
      </button>
    </div>

    <!-- SEARCH & FILTER BAR (Hanya Status) -->
    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 32px; overflow-x: auto; padding-bottom: 4px;" id="filterContainer">
      <input type="text" id="searchInput" placeholder="Search clinics, doctors..." style="padding: 10px 16px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; min-width: 280px; outline: none; background: white; color: var(--dark-navy);">
      <button class="btn btn-primary filter-btn" data-filter="All" style="border-radius: 20px; padding: 8px 20px; font-size: 13px; white-space: nowrap;">All Status</button>
      <button class="btn btn-outline filter-btn" data-filter="Completed" style="border-radius: 20px; padding: 8px 20px; font-size: 13px; background: white; white-space: nowrap;">Completed</button>
      <button class="btn btn-outline filter-btn" data-filter="Cancelled" style="border-radius: 20px; padding: 8px 20px; font-size: 13px; background: white; white-space: nowrap;">Cancelled</button>
    </div>

    <!-- HISTORY CARDS -->
    <div style="display: flex; flex-direction: column; gap: 16px;" id="historyList">
      @forelse($histories as $history)
        <div class="card card-shadow history-card-item" 
             data-status="{{ $history->status == 'C' ? 'Cancelled' : 'Completed' }}" 
             data-clinic="{{ strtolower($history->clinic) }}" 
             data-doctor="{{ strtolower($history->doctor_name) }}"
             style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; margin-bottom: 0; border-radius: 12px; background: white; border: 1px solid var(--border); transition: 0.3s;">
          
          <div style="display: flex; gap: 20px; align-items: center;">
            <div style="width: 56px; height: 56px; border-radius: 12px; background: var(--bg-gray); display: flex; align-items: center; justify-content: center; font-size: 24px; border: 1px solid var(--border); color: #ef4444;">
              @if($history->status == 'C') 🚫 @else 🩺 @endif
            </div>
            <div>
              <h3 style="margin-bottom: 4px; font-size: 16px; font-weight: 700; color: var(--dark-navy);">{{ $history->clinic }}</h3>
              <p style="color: var(--text-gray); font-size: 13px; margin-bottom: 6px;">{{ $history->doctor_name }} • {{ $history->specialty ?? 'Consultation' }}</p>
              <p style="font-size: 12px; font-weight: 600; color: var(--text-gray); display: flex; align-items: center; gap: 6px;">
                <span style="color: var(--primary-green);">🗓️</span> {{ \Carbon\Carbon::parse($history->appointment_date)->format('d M Y') }}
              </p>
            </div>
          </div>

          <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; justify-content: center; gap: 12px;">
            @if($history->status == 'C')
        <span class="badge badge-cancelled" style="background:#fee2e2; color:#dc2626;">Cancelled</span>
            @elseif($history->status == 'F')
                <span class="badge badge-completed" style="background:#dcfce7; color:#16a34a;">Completed</span>
                <a href="{{ url('/patient/visit-detail?id=' . $history->id_appointments) }}" class="btn btn-outline">View Details</a>
            @endif
          </div>
          
        </div>
      @empty
        <div style="text-align: center; padding: 60px 24px; background: white; border-radius: 12px; border: 1px solid var(--border);" id="emptyState">
          <div style="font-size: 48px; margin-bottom: 16px;">🗂️</div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">No Medical History</h3>
          <p style="color: var(--text-gray);">You haven't completed or cancelled any consultations yet.</p>
        </div>
      @endforelse

      <!-- State Jika Filter Tidak Menemukan Hasil -->
      <div style="text-align: center; padding: 60px 24px; background: white; border-radius: 12px; border: 1px solid var(--border); display: none;" id="noMatchState">
        <div style="font-size: 48px; margin-bottom: 16px;">🔍</div>
        <h3 style="font-size: 18px; margin-bottom: 8px;">No Results Found</h3>
        <p style="color: var(--text-gray);">Try adjusting your search or filter criteria.</p>
      </div>

    </div>
    
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterBtns = document.querySelectorAll('.filter-btn');
      const searchInput = document.getElementById('searchInput');
      const cards = document.querySelectorAll('.history-card-item');
      const noMatchState = document.getElementById('noMatchState');

      function filterHistory() {
        const activeBtn = document.querySelector('.filter-btn.btn-primary');
        const filterType = activeBtn ? activeBtn.getAttribute('data-filter') : 'All';
        const query = searchInput.value.toLowerCase();

        let visibleCount = 0;

        cards.forEach(card => {
          const status = card.getAttribute('data-status');
          const clinic = card.getAttribute('data-clinic');
          const doctor = card.getAttribute('data-doctor');

          // Cek Tombol Filter (Hanya All, Completed, Cancelled)
          let matchFilter = false;
          if (filterType === 'All') matchFilter = true;
          else if (filterType === 'Completed' && status === 'Completed') matchFilter = true;
          else if (filterType === 'Cancelled' && status === 'Cancelled') matchFilter = true;

          // Cek Kolom Pencarian
          let matchSearch = clinic.includes(query) || doctor.includes(query);

          if (matchFilter && matchSearch) {
            card.style.display = 'flex';
            visibleCount++;
          } else {
            card.style.display = 'none';
          }
        });

        // Tampilkan "No Results Found"
        if (cards.length > 0) {
            noMatchState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
      }

      // Event Listener Tombol Filter
      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          filterBtns.forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline');
            b.style.background = 'white';
          });
          btn.classList.remove('btn-outline');
          btn.classList.add('btn-primary');
          btn.style.background = ''; 

          filterHistory();
        });
      });

      // Event Listener Pencarian
      searchInput.addEventListener('input', filterHistory);
    });
  </script>
</body>
</html>