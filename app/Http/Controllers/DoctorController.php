<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // --- 1. DASHBOARD ---
    public function dashboard()
    {
        $doctorId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $todaySchedule = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->where('schedule_date', $today)
            ->first();

        $todaysPatients = [];
        $totalPatients = 0;
        $pendingExams = 0;
        $completedExams = 0;

        if ($todaySchedule) {
            $todaysPatients = DB::table('appointments')
                ->join('users', 'appointments.id_user', '=', 'users.id_user')
                ->leftJoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
                ->where('appointments.id_schedule', $todaySchedule->id_schedule)
                ->select(
                    'appointments.*', 
                    'users.user_name as name', 
                    'patient_profiles.gender',
                    'patient_profiles.date_of_birth'
                )
                ->orderBy('appointments.queue_number', 'asc')
                ->get();

            $totalPatients = $todaysPatients->count();
            $pendingExams = $todaysPatients->whereIn('status', ['W', 'I'])->count();
            $completedExams = $todaysPatients->where('status', 'F')->count();
        }

        return view('doctor-dashboard', compact('todaySchedule', 'todaysPatients', 'totalPatients', 'pendingExams', 'completedExams'));
    }

    // --- 2. TODAY'S PATIENTS (VERSI MULTI-SCHEDULE - SUDAH DIPERBAIKI) ---
    public function patients()
    {
        $doctorId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        // Ambil SEMUA schedule dokter hari ini (bisa lebih dari 1 shift)
        $todaySchedules = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->where('schedule_date', $today)
            ->get();

        // Kumpulkan semua id_schedule hari ini ke dalam Array
        $scheduleIds = $todaySchedules->pluck('id_schedule')->toArray();

        // Tarik semua pasien dari semua ID schedule tersebut
        $patients = DB::table('appointments')
            ->join('users', 'appointments.id_user', '=', 'users.id_user')
            ->leftJoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule') 
            ->whereIn('appointments.id_schedule', $scheduleIds)
            ->select(
                'appointments.*', 
                'users.user_name as name', 
                'patient_profiles.gender',
                'patient_profiles.date_of_birth',
                'doctor_schedules.shift' 
            )
            ->orderBy('doctor_schedules.shift', 'asc') 
            ->orderBy('appointments.queue_number', 'asc')
            ->get();

        return view('doctor-patients', compact('patients'));
    }

    // --- 3. MEDICAL RECORDS ---
    public function records()
    {
        $records = DB::table('medical_records')
            ->join('appointments', 'medical_records.id_appointments', '=', 'appointments.id_appointments')
            ->join('users as patient', 'appointments.id_user', '=', 'patient.id_user')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users as doctor', 'doctor_schedules.id_user', '=', 'doctor.id_user')
            ->select(
                'medical_records.id_med_records as id_record',
                'medical_records.diagnosis',
                'medical_records.notes',
                'appointments.appointment_date as check_up_date',
                'patient.user_name as patient_name',
                'doctor.user_name as doctor_name'
            )
            ->orderBy('appointments.appointment_date', 'desc')
            ->get();

        foreach ($records as $record) {
            $record->prescriptions = DB::table('medicines_record_medicine')
                ->join('medicines', 'medicines_record_medicine.id_med', '=', 'medicines.id_med')
                ->where('medicines_record_medicine.id_med_records', $record->id_record)
                ->select('medicines.med_name', 'medicines_record_medicine.dosage', 'medicines_record_medicine.quantity')
                ->get();
        }

        return view('doctor-records', compact('records'));
    }

    // --- FITUR JADWAL DOKTER ---
    public function schedule()
    {
        $doctorId = Auth::user()->id_user;
        
        // Ambil semua jadwal milik dokter yang sedang login
        $schedules = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->orderBy('schedule_date', 'asc')
            ->get();

        return view('doctor-schedule', compact('schedules'));
    }

    // --- 4. NEW ENTRY ---
    public function newEntry(Request $request)
    {
        $appointmentId = $request->query('appointment_id');
        $medicines = DB::table('medicines')->where('stock', '>', 0)->get();

        $appointment = null;
        if ($appointmentId) {
            $appointment = DB::table('appointments')
                ->join('users', 'appointments.id_user', '=', 'users.id_user')
                ->leftjoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
                ->where('appointments.id_appointments', $appointmentId)
                ->select(
                    'appointments.*', 
                    'users.user_name as patient_name', 
                    'patient_profiles.gender',
                    'patient_profiles.date_of_birth'
                )
                ->first();
        }

        return view('doctor-new-entry', compact('appointmentId', 'medicines', 'appointment'));
    }

    // --- 5. STORE ENTRY TO HEIDISQL ---
    public function storeEntry(Request $request)
    {
        $appointmentId = $request->query('appointment_id') ?? $request->input('appointment_id') ?? $request->appointment_id;
        
        if (!$appointmentId) {
            return redirect()->back()->withErrors(['error' => 'ID Antrean gagal divalidasi. Hubungi Admin.']);
        }

        $recordId = 'MR-' . rand(100000, 999999);

        $vitalsAndNotes = "--- PATIENT VITALS ---\n"
                        . "• Blood Pressure : " . ($request->blood_pressure ?? '-') . " mmHg\n"
                        . "• Heart Rate     : " . ($request->heart_rate ?? '-') . " bpm\n"
                        . "• Temperature    : " . ($request->temperature ?? '-') . " °C\n\n"
                        . "--- PRESENTING SYMPTOMS ---\n"
                        . ($request->symptoms ?? '-') . "\n\n"
                        . "--- CLINICAL OBSERVATIONS ---\n"
                        . ($request->notes ?? '-');

        DB::table('medical_records')->insert([
            'id_med_records'  => $recordId,
            'id_appointments' => $appointmentId, 
            'diagnosis'       => $request->diagnosis,
            'notes'           => $vitalsAndNotes,
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('appointments')
            ->where('id_appointments', $appointmentId)
            ->update(['status' => 'F']);

        if ($request->has('medicines')) {
            $meds = $request->medicines;
            $doses = $request->dosages ?? [];
            $freqs = $request->frequencies ?? [];

            foreach ($meds as $index => $medId) {
                if (!empty($medId)) {
                    $d = $doses[$index] ?? '';
                    $f = $freqs[$index] ?? '';
                    
                    $finalDosage = "As prescribed";
                    if ($d != '' && $f != '') {
                        $finalDosage = "$d ($f)";
                    } elseif ($d != '') {
                        $finalDosage = $d;
                    } elseif ($f != '') {
                        $finalDosage = $f;
                    }

                    DB::table('medicines_record_medicine')->insert([
                        'id_med_record_medicines' => 'RM-' . rand(100000, 999999), 
                        'id_med'                 => $medId,
                        'id_med_records'         => $recordId,
                        'quantity'               => 1,
                        'dosage'                 => $finalDosage,
                        'created_at'             => now(),
                        'updated_at'             => now()
                    ]);

                    DB::table('medicines')->where('id_med', $medId)->decrement('stock', 1);
                }
            }
        }
        return redirect('/doctor/records');
    }

    // --- FUNGSI TAMPILKAN HALAMAN PROFIL ---
    public function profile()
    {
        return view('doctor-profile');
    }

    // --- FUNGSI UPDATE PROFIL ---
    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id_user;

        DB::table('users')->where('id_user', $userId)->update([
            'user_name'  => $request->user_name,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
            'user_dept'  => $request->user_dept,
        ]);

        return redirect()->back(); 
    }

    // --- FUNGSI UPDATE PASSWORD ---
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if ($request->current_password === $user->password) {
            
            if ($request->new_password === $request->current_password) {
                return redirect()->back()->with('error', 'New password cannot be the same as your current password!');
            }

            DB::table('users')->where('id_user', $user->id_user)->update([
                'password' => $request->new_password
            ]);

            return redirect()->back()->with('success', 'Password successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Incorrect current password!');
        }
    }
}