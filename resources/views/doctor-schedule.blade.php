<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Schedule - MedCampus</title>
  <link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
  <style>
    .sch-wrapper { background: #fff; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 24px; }
    .sch-top { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--border); }
    .week-nav { font-size: 18px; font-weight: 700; color: var(--dark-navy); display: flex; align-items: center; gap: 16px; }
    .week-nav span { cursor: pointer; color: var(--text-gray); padding: 4px 12px; border-radius: 4px; transition: 0.2s; font-weight: 900; }
    .week-nav span:hover { background: var(--bg-gray); color: var(--dark-navy); }
    .view-tabs { display: flex; background: var(--bg-gray); border-radius: 8px; padding: 4px; }
    .view-tabs button { background: transparent; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 600; color: var(--text-gray); cursor: pointer; font-size: 13px; transition: 0.2s; }
    .view-tabs button.active { background: #fff; color: var(--dark-navy); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .sch-grid { display: grid; grid-template-columns: 80px repeat(7, 1fr); }
    .sch-header-cell { padding: 16px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
    .sch-header-cell:last-child { border-right: none; }
    .sch-header-cell .day-name { font-size: 11px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; margin-bottom: 6px; display: block; }
    .sch-header-cell .day-date { font-size: 20px; font-weight: 700; color: var(--dark-navy); display: block; }
    .sch-header-cell.is-today .day-name { color: var(--primary-green); }
    .sch-header-cell.is-today .day-date { color: var(--primary-green); }
    .time-col-header { display: flex; align-items: center; font-size: 11px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; border-bottom: 1px solid var(--border); border-right: 1px solid var(--border); padding: 16px; }
    .sch-time { padding: 16px; font-weight: 700; color: var(--text-gray); font-size: 13px; text-align: center; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: center; flex-direction: column; }
    .sch-time span { font-size: 11px; font-weight: 700; }
    .sch-cell { padding: 16px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
    .sch-cell:last-child { border-right: none; }
    .shift-card { background: #f8fafc; border: 1px solid var(--border); border-left: 4px solid var(--primary-green); border-radius: 6px; padding: 12px; height: 100%; box-sizing: border-box; }
    .shift-card h4 { font-size: 13px; color: var(--dark-navy); margin-bottom: 6px; font-weight: 700; }
    .shift-card p { font-size: 11px; color: var(--text-gray); margin: 0; }
    .lunch-break { grid-column: 1 / -1; background: #f8fafc; text-align: center; padding: 10px; font-size: 11px; font-weight: 700; color: #94a3b8; letter-spacing: 2px; border-bottom: 1px solid var(--border); }
    .today-shift-card { transition: 0.2s; }
    .today-shift-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-left">
        <div class="nav-logo">
          <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
          MedCampus
        </div>
      </div>
      <div class="nav-links">
        <a href="{{ url('/doctor/dashboard') }}">Dashboard</a>
        <a href="{{ url('/doctor/patients') }}">Today's Patients</a>
        <a href="{{ url('/doctor/records') }}">Medical Records</a>
        <a href="{{ url('/doctor/schedule') }}" class="active">Schedule</a>
      </div>
      <div class="nav-profile" style="position: relative; display: flex; align-items: center; gap: 16px;">
        <div class="bell-wrapper"><div class="icon-btn">🔔</div></div>
        <div id="mcProfileToggle" onclick="toggleProfileDropdown(event)" style="display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; background: var(--bg-gray); padding: 4px 12px 4px 4px; border-radius: 24px;">
          <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--light-green); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
            {{ strtoupper(substr(Auth::user()->user_name, 0, 2)) }}
          </div>
          <span style="font-size: 13px; font-weight: 600; color: var(--dark-navy);">{{ Auth::user()->user_name }}</span>
          <span style="font-size: 10px; color: var(--text-gray); margin-left: 4px;">▼</span>
        </div>
        <div id="mcProfileDropdown" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; width: 170px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid var(--border); display: none; flex-direction: column; overflow: hidden; z-index: 1000; text-align: left;">
          <a href="{{ url('/doctor/profile') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Profile</a>
          <a href="{{ url('/logout') }}" style="padding: 12px 16px; font-size: 13px; font-weight: 500; color: var(--dark-navy); text-decoration: none; display: flex; align-items: center; gap: 10px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <main class="main-content container">
    <div class="flex-between">
      <div>
        <h1 style="font-size:32px;margin-bottom:8px;">Schedule</h1>
        <p style="color:var(--text-gray);font-size:14px;">Weekly clinic room assignments and consultation times.</p>
      </div>
      <div>
        <button class="btn btn-outline" onclick="window.print()">🖨 Print Schedule</button>
      </div>
    </div>

    <div class="sch-wrapper">
      <div class="sch-top">
        <div class="week-nav">
          <span onclick="changeDate(-1)">&lt;</span>
          <div id="dateLabel" style="width:250px; text-align:center;">Loading...</div>
          <span onclick="changeDate(1)">&gt;</span>
        </div>
        <div class="view-tabs">
          <button id="tabWeekly" class="active" onclick="switchView('weekly')">Weekly</button>
          <button id="tabToday" onclick="switchView('today')">Today</button>
        </div>
      </div>

      <div class="sch-grid" id="weeklyGrid"></div>
      
      <div id="todayGrid" style="display:none; padding:32px 24px; background:#fff;"></div>
    </div>
  </main>

  <script>
    const rawData = {!! json_encode($schedules) !!};
    const DB_SCHEDULES = rawData.map(s => ({
        id: s.id_schedule,
        date: s.schedule_date,
        shift: s.shift,
        room: s.room
    }));

    let viewMode = 'weekly';
    const serverTodayStr = "{{ now()->format('Y-m-d') }}";
    const SERVER_TODAY = new Date(serverTodayStr + "T00:00:00"); 
    let currentMonday = getMonday(SERVER_TODAY);
    let selectedDate = new Date(SERVER_TODAY);

    function getFormatDate(d) {
        let yyyy = d.getFullYear();
        let mm = String(d.getMonth() + 1).padStart(2, '0');
        let dd = String(d.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function getMonday(d) {
        let date = new Date(d);
        let day = date.getDay();
        let diff = date.getDate() - day + (day === 0 ? -6 : 1);
        return new Date(date.setDate(diff));
    }

    function changeDate(offset) {
        if (viewMode === 'weekly') {
            currentMonday.setDate(currentMonday.getDate() + (offset * 7));
            renderCalendar();
        } else {
            selectedDate.setDate(selectedDate.getDate() + offset);
            renderToday();
        }
    }

    function switchView(mode) {
        viewMode = mode;
        document.getElementById('tabWeekly').classList.toggle('active', mode === 'weekly');
        document.getElementById('tabToday').classList.toggle('active', mode === 'today');

        if (mode === 'today') {
            selectedDate = new Date(SERVER_TODAY);
            document.getElementById('weeklyGrid').style.display = 'none';
            document.getElementById('todayGrid').style.display = 'block';
            renderToday();
        } else {
            currentMonday = getMonday(SERVER_TODAY);
            document.getElementById('weeklyGrid').style.display = 'grid';
            document.getElementById('todayGrid').style.display = 'none';
            renderCalendar();
        }
    }

    function renderCalendar() {
        const grid = document.getElementById('weeklyGrid');
        grid.innerHTML = '';
        const days = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
        let weekDates = [];

        let headerHtml = `<div class="time-col-header">TIME</div>`;
        for (let i = 0; i < 7; i++) {
            let colDate = new Date(currentMonday);
            colDate.setDate(colDate.getDate() + i);
            let dateStr = getFormatDate(colDate);
            weekDates.push(dateStr);
            
            let isToday = (dateStr === serverTodayStr);
            headerHtml += `
                <div class="sch-header-cell ${isToday ? 'is-today' : ''}">
                    <span class="day-name">${days[i]} ${isToday ? '(TODAY)' : ''}</span>
                    <span class="day-date">${colDate.getDate()}</span>
                </div>
            `;
        }
        grid.innerHTML += headerHtml;

        let weekEndDate = new Date(currentMonday);
        weekEndDate.setDate(weekEndDate.getDate() + 6);
        document.getElementById('dateLabel').textContent = 
            `${currentMonday.toLocaleDateString('en-US', {month:'short', day:'numeric'})} – ${weekEndDate.toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'})}`;

        let currentWeekSchedules = DB_SCHEDULES.filter(s => weekDates.includes(s.date));
        
        // 🌟 PERBAIKAN: Urutkan Waktu Secara Logis (Pagi ke Malam), Bukan Abjad!
        let uniqueShifts = [...new Set(currentWeekSchedules.map(s => s.shift))];
        uniqueShifts.sort((a, b) => {
            let jamA = a.toLowerCase().includes('morning') ? 8 : (a.toLowerCase().includes('afternoon') ? 13 : parseInt(a.split(':')[0]));
            let jamB = b.toLowerCase().includes('morning') ? 8 : (b.toLowerCase().includes('afternoon') ? 13 : parseInt(b.split(':')[0]));
            return jamA - jamB;
        });

        if (uniqueShifts.length === 0) {
            grid.innerHTML += `<div style="grid-column: 1 / -1; text-align:center; padding: 50px; color: var(--text-gray); font-weight:600;">No schedules found for this week.</div>`;
            return;
        }

        let hasLunchBreak = false;
        uniqueShifts.forEach(shiftTime => {
            let h = 0, mm = '00', ampm = 'AM', timeLabel = '';
            
            // 🌟 PERBAIKAN: Cegah NaN dengan mendeteksi teks Morning/Afternoon
            if (shiftTime.toLowerCase().includes('morning')) {
                h = 8; ampm = 'AM'; timeLabel = '08:00';
            } else if (shiftTime.toLowerCase().includes('afternoon')) {
                h = 13; ampm = 'PM'; timeLabel = '01:00';
                if (!hasLunchBreak) { grid.innerHTML += `<div class="lunch-break">🍴 LUNCH BREAK</div>`; hasLunchBreak = true; }
            } else {
                let startTime = shiftTime.split('-')[0].trim();
                let timeParts = startTime.split(':');
                h = parseInt(timeParts[0]);
                mm = timeParts[1] || '00';
                ampm = h >= 12 ? 'PM' : 'AM';
                
                if (ampm === 'PM' && !hasLunchBreak) {
                    grid.innerHTML += `<div class="lunch-break">🍴 LUNCH BREAK</div>`;
                    hasLunchBreak = true;
                }
                let displayHour = h % 12;
                if (displayHour === 0) displayHour = 12;
                timeLabel = `${displayHour < 10 ? '0'+displayHour : displayHour}:${mm}`;
            }

            let rowHtml = `<div class="sch-time">${timeLabel}<br><span>${ampm}</span></div>`;

            for (let i = 0; i < 7; i++) {
                let cellData = currentWeekSchedules.find(s => s.date === weekDates[i] && s.shift === shiftTime);
                if (cellData) {
                    rowHtml += `<div class="sch-cell"><div class="shift-card"><h4>${cellData.room}</h4><p>Consultation</p></div></div>`;
                } else {
                    rowHtml += `<div class="sch-cell"></div>`;
                }
            }
            grid.innerHTML += rowHtml;
        });
    }

    function renderToday() {
        const grid = document.getElementById('todayGrid');
        const dateStr = getFormatDate(selectedDate);
        const isActuallyToday = (dateStr === serverTodayStr);
        
        document.getElementById('dateLabel').textContent = 
            selectedDate.toLocaleDateString('en-US', {weekday:'long', month:'long', day:'numeric', year:'numeric'}) + (isActuallyToday ? ' (Today)' : '');

        const todaySchedules = DB_SCHEDULES.filter(s => s.date === dateStr).sort((a,b) => {
            let jamA = a.shift.toLowerCase().includes('morning') ? 8 : (a.shift.toLowerCase().includes('afternoon') ? 13 : parseInt(a.shift.split(':')[0]));
            let jamB = b.shift.toLowerCase().includes('morning') ? 8 : (b.shift.toLowerCase().includes('afternoon') ? 13 : parseInt(b.shift.split(':')[0]));
            return jamA - jamB;
        });

        if (todaySchedules.length === 0) {
            grid.innerHTML = `<div style="text-align:center; padding: 80px 20px; color: var(--text-gray); font-size:15px; font-weight:600;">No schedules assigned for this date. ☕</div>`;
            return;
        }

        let html = `<div style="display:flex; flex-direction:column; gap:16px; max-width: 800px; margin: 0 auto;">`;
        todaySchedules.forEach(s => {
            html += `
                <div class="today-shift-card" style="display:flex; align-items:center; background:#f8fafc; border:1px solid var(--border); border-left:4px solid var(--primary-green); border-radius:10px; padding:24px;">
                    <div style="width:180px; font-weight:800; color:var(--dark-navy); font-size:16px; display:flex; align-items:center; gap:8px;">
                        🕒 ${s.shift}
                    </div>
                    <div style="flex:1;">
                        <h3 style="margin:0 0 6px 0; color:var(--dark-navy); font-size:18px;">${s.room}</h3>
                        <p style="margin:0; color:var(--text-gray); font-size:13px; font-weight:600;">Standard Clinical Shift • 🏥 Outpatient Department</p>
                    </div>
                    <div>
                        <span class="badge" style="background:var(--light-green); color:var(--primary-green); padding:8px 16px; border-radius:8px; font-weight:700; font-size:13px;">✅ Scheduled</span>
                    </div>
                </div>
            `;
        });
        html += `</div>`;
        grid.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', renderCalendar);
    
    function toggleProfileDropdown(event) {
        if (event) event.stopPropagation();
        const drop = document.getElementById('mcProfileDropdown');
        drop.style.display = (drop.style.display === 'none' || drop.style.display === '') ? 'flex' : 'none';
    }
    document.addEventListener('click', function(e) {
        const drop = document.getElementById('mcProfileDropdown');
        const trigger = document.getElementById('mcProfileToggle');
        if (drop && drop.style.display === 'flex') {
            if (!trigger.contains(e.target) && !drop.contains(e.target)) {
                drop.style.display = 'none';
            }
        }
    });
  </script>
</body>
</html>