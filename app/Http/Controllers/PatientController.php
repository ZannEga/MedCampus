<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // 1. Halaman Dashboard Pasien
    public function dashboard()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        $estimatedTime = '—';
        if ($activeQueue) {
            $waktuMulai = strtotime('08:00');
            
            if (stripos($activeQueue->shift, 'afternoon') !== false) {
                $waktuMulai = strtotime('13:00');
            } elseif (strpos($activeQueue->shift, '-') !== false) {
                $shiftParts = explode('-', $activeQueue->shift);
                $waktuMulai = strtotime(trim($shiftParts[0]));
            }
            
            $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
            $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));
        }

        return view('dashboard', compact('activeQueue', 'estimatedTime'));
    }

    // 2. Halaman Pilih Klinik & Jadwal (Booking)
    public function booking()
    {
        $doctors = DB::table('users')
                    ->whereIn('id_user', function($query) {
                        $query->select('id_user')->from('doctor_schedules');
                    })
                    ->select('id_user', 'user_name', 'user_dept as department')
                    ->get();

        return view('booking', compact('doctors'));
    }

    // 3. Halaman Konfirmasi Pembayaran
    public function checkout()
    {
        return view('checkout');
    }

    // 4. Halaman Sukses Booking
    public function success()
    {
        return view('success');
    }

    // 5. Halaman Tiket Digital
    public function ticket()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        if (!$activeQueue) {
            return redirect('/patient/dashboard');
        }

        $waktuMulai = strtotime('08:00');
        if (stripos($activeQueue->shift, 'afternoon') !== false) {
            $waktuMulai = strtotime('13:00');
        } elseif (strpos($activeQueue->shift, '-') !== false) {
            $shiftParts = explode('-', $activeQueue->shift);
            $waktuMulai = strtotime(trim($shiftParts[0]));
        }
        $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
        $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));

        return view('ticket', compact('activeQueue', 'estimatedTime'));
    }

    // 6. Halaman Pantau Antrean Live
    public function queueDetail()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        // Cari antrean aktif persis seperti di Dashboard
        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        // Jika tidak ada antrean, tendang balik ke dashboard
        if (!$activeQueue) {
            return redirect('/patient/dashboard');
        }

        // Hitung Estimasi Jam
        $waktuMulai = strtotime('08:00');
        if (stripos($activeQueue->shift, 'afternoon') !== false) {
            $waktuMulai = strtotime('13:00');
        } elseif (strpos($activeQueue->shift, '-') !== false) {
            $shiftParts = explode('-', $activeQueue->shift);
            $waktuMulai = strtotime(trim($shiftParts[0]));
        }
        $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
        $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));

        // Hitung berapa orang yang antre di depan pasien ini
        $aheadCount = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->whereIn('status', ['W', 'I'])
            ->where('queue_number', '<', $activeQueue->queue_number)
            ->count();
        
        // Simulasi persentase progress
        $totalInSchedule = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->count();
        
        $progress = $totalInSchedule > 0 ? round((($totalInSchedule - $aheadCount - 1) / $totalInSchedule) * 100) : 0;
        if ($progress < 0) $progress = 0;
        if ($activeQueue->status == 'I') $progress = 90;

        return view('queue-detail', compact('activeQueue', 'estimatedTime', 'aheadCount', 'progress'));
    }

    // 7. Halaman Riwayat Rekam Medis
    public function history()
    {
        $userId = Auth::user()->id_user;

        $histories = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereNotIn('appointments.status', ['W', 'I'])
            ->orderBy('appointments.appointment_date', 'desc')
            ->get();

        return view('history', compact('histories'));
    }

    // 8. Halaman Detail Kunjungan (Resep Obat, dll)
    public function visitDetail(Request $request)
    {
        $appointmentId = $request->input('id');
        $userId = Auth::user()->id_user;

        // 1. Tarik data Antrean, Dokter, dan Rekam Medis
        $detail = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->leftJoin('medical_records', 'appointments.id_appointments', '=', 'medical_records.id_appointments')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'users.user_name as doctor_name',
                'users.user_dept as specialty',
                'medical_records.diagnosis',
                'medical_records.notes',
                'medical_records.id_med_records'
            )
            ->where('appointments.id_appointments', $appointmentId)
            ->where('appointments.id_user', $userId)
            ->first();

        if (!$detail) {
            return redirect('/patient/history');
        }

        // 2. Tarik data Resep Obat (Hanya jika rekam medis sudah ada)
        $prescriptions = [];
        if (!empty($detail->id_med_records)) {
            $prescriptions = DB::table('medicines_record_medicine')
                ->join('medicines', 'medicines_record_medicine.id_med', '=', 'medicines.id_med')
                ->select(
                    'medicines.med_name', 
                    'medicines.med_unit', 
                    'medicines_record_medicine.quantity', 
                    'medicines_record_medicine.dosage'
                )
                ->where('medicines_record_medicine.id_med_records', $detail->id_med_records)
                ->get();
        }

        return view('visit-detail', compact('detail', 'prescriptions'));
    }

    // 9. Halaman Profil Pasien (Mahasiswa)
    public function profile()
    {
        $userId = Auth::user()->id_user;

        // Tarik gabungan data dari tabel users dan patient_profiles
        $profile = DB::table('users')
            ->leftJoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
            ->select('users.*', 'patient_profiles.*')
            ->where('users.id_user', $userId)
            ->first();

        return view('patient-profile', compact('profile'));
    }

    // Fungsi untuk menyimpan perubahan Profil Pasien
    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id_user;

        // Gabungkan First Name dan Last Name untuk tabel users
        $fullName = $request->input('first_name') . ' ' . $request->input('last_name');
        
        DB::table('users')->where('id_user', $userId)->update([
            'user_name'  => $fullName,
            'user_phone' => $request->input('phone_number'),
        ]);

        // Cek apakah pasien ini sudah punya profil atau belum
        $existingProfile = DB::table('patient_profiles')->where('id_user', $userId)->first();

        if ($existingProfile) {
            // Jika SUDAH ADA (seperti Budi), cukup perbarui datanya saja
            DB::table('patient_profiles')->where('id_user', $userId)->update([
                'gender'        => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
            ]);
        } else {
            // Jika BELUM ADA (seperti Coba Coba), buatkan baris baru dan cetak id_patient baru!
            DB::table('patient_profiles')->insert([
                'id_patient'    => 'PT-' . rand(100000, 999999), 
                'id_user'       => $userId,
                'nim_nip'       => $userId, 
                'gender'        => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'address'       => '-',
                'blood_type'    => '-',
            ]);
        }

        return redirect('/patient/profile');
    }

    // Fungsi untuk memproses data dari halaman Checkout ke Database
    public function storeBooking(Request $request)
    {
        // 1. Ambil ID Pasien (Mahasiswa) yang sedang login
        $userId = Auth::user()->id_user;

        // 2. Ambil data yang dikirim dari form Checkout
        $doctorId = $request->input('doctor_id');
        $dateRaw = $request->input('date_raw'); // format: YYYY-MM-DD
        $shiftName = $request->input('slot'); 
        $clinicName = $request->input('clinic');

        // 3. Cari jadwal dokter di tabel doctor_schedules
        $schedule = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->whereDate('schedule_date', $dateRaw)
            ->where('shift', 'LIKE', "%$shiftName%")
            ->first();

        // 🌟 PERBAIKAN FINAL: Tambahkan kolom 'quota' agar database tidak marah
        if (!$schedule) {
            $idSchedule = 'SC-' . rand(100000, 999999);
            DB::table('doctor_schedules')->insert([
                'id_schedule'   => $idSchedule,
                'id_user'       => $doctorId,
                'schedule_date' => $dateRaw,
                'shift'         => $shiftName,
                'room'          => $clinicName . ' - R.101',
                'quota'         => 50 // <-- Ini dia penangkal errornya!
            ]);
        } else {
            $idSchedule = $schedule->id_schedule;
        }

        // 4. Tentukan Nomor Antrean (Otomatis hitung dari antrean terakhir)
        $lastQueue = DB::table('appointments')
            ->where('id_schedule', $idSchedule)
            ->whereDate('appointment_date', $dateRaw)
            ->max('queue_number');
        
        $newQueue = $lastQueue ? $lastQueue + 1 : 1;
        $appointmentId = 'AP-' . rand(100000, 999999); // Generate ID Antrean

        // 5. Tembak ke tabel appointments!
        DB::table('appointments')->insert([
            'id_appointments'  => $appointmentId,
            'id_user'          => $userId,
            'id_schedule'      => $idSchedule,
            'appointment_date' => $dateRaw,
            'queue_number'     => $newQueue,
            'status'           => 'W', // W = Waiting
        ]);

        // 6. Langsung lempar kembali ke Dashboard agar pasien bisa melihat tiketnya
        return redirect('/patient/dashboard');
    }

    // Fungsi untuk membatalkan antrean
    public function cancelAppointment(Request $request)
    {
        $userId = Auth::user()->id_user;
        $appointmentId = $request->input('appointment_id');

        // Ubah status antrean menjadi 'C' (Cancelled) di database
        DB::table('appointments')
            ->where('id_appointments', $appointmentId)
            ->where('id_user', $userId) // Validasi keamanan agar hanya bisa membatalkan miliknya sendiri
            ->update(['status' => 'C']);

        // Lempar kembali ke dashboard, sistem akan otomatis membaca "No Active Queue"
        return redirect('/patient/dashboard');
    }

    public function getDoctorShifts(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date'); // Format: YYYY-MM-DD

        // Cari jadwal yang BENAR-BENAR dibuat Admin di database
        $shifts = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->whereDate('schedule_date', $date)
            ->get();

        return response()->json($shifts);
    }
}