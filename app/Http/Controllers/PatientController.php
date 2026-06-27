<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
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
            $estimatedTime = $activeQueue->booking_time ? date('H:i', strtotime($activeQueue->booking_time)) : '—';
        }

        return view('dashboard', compact('activeQueue', 'estimatedTime'));
    }

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

    public function checkout()
    {
        return view('checkout');
    }

    public function success()
    {
        return view('success');
    }

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

        $estimatedTime = $activeQueue->booking_time ? date('H:i', strtotime($activeQueue->booking_time)) : '—';

        return view('ticket', compact('activeQueue', 'estimatedTime'));
    }

    public function queueDetail()
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

        $estimatedTime = $activeQueue->booking_time ? date('H:i', strtotime($activeQueue->booking_time)) : '—';

        $aheadCount = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->whereIn('status', ['W', 'I'])
            ->where('queue_number', '<', $activeQueue->queue_number)
            ->count();
        
        $totalInSchedule = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->count();
        
        $progress = $totalInSchedule > 0 ? round((($totalInSchedule - $aheadCount - 1) / $totalInSchedule) * 100) : 0;
        if ($progress < 0) $progress = 0;
        if ($activeQueue->status == 'I') $progress = 90;

        return view('queue-detail', compact('activeQueue', 'estimatedTime', 'aheadCount', 'progress'));
    }

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

    public function visitDetail(Request $request)
    {
        $appointmentId = $request->input('id');
        $userId = Auth::user()->id_user;

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

    public function profile()
    {
        $userId = Auth::user()->id_user;

        $profile = DB::table('users')
            ->leftJoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
            ->select('users.*', 'patient_profiles.*')
            ->where('users.id_user', $userId)
            ->first();

        return view('patient-profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id_user;

        $fullName = $request->input('first_name') . ' ' . $request->input('last_name');
        
        DB::table('users')->where('id_user', $userId)->update([
            'user_name'  => $fullName,
            'user_phone' => $request->input('phone_number'),
        ]);

        $existingProfile = DB::table('patient_profiles')->where('id_user', $userId)->first();

        if ($existingProfile) {
            DB::table('patient_profiles')->where('id_user', $userId)->update([
                'gender'        => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
            ]);
        } else {
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

    public function storeBooking(Request $request)
    {
        $userId = Auth::user()->id_user;
        $dateRaw = $request->input('date_raw');
        $timeSlot = $request->input('booking_time'); // Kolom baru kita
        $idSchedule = $request->input('id_schedule'); 

        $lastQueue = DB::table('appointments')
            ->where('id_schedule', $idSchedule)
            ->whereDate('appointment_date', $dateRaw)
            ->max('queue_number');
        
        $newQueue = $lastQueue ? $lastQueue + 1 : 1;
        $appointmentId = 'AP-' . rand(100000, 999999);

        DB::table('appointments')->insert([
            'id_appointments'  => $appointmentId,
            'id_user'          => $userId,
            'id_schedule'      => $idSchedule,
            'appointment_date' => $dateRaw,
            'booking_time'     => $timeSlot, 
            'queue_number'     => $newQueue,
            'status'           => 'W',
            'created_at'       => now(),
            'updated_at'       => now()
        ]);

        return redirect('/patient/dashboard');
    }

    public function cancelAppointment(Request $request)
    {
        $userId = Auth::user()->id_user;
        $appointmentId = $request->input('appointment_id');

        DB::table('appointments')
            ->where('id_appointments', $appointmentId)
            ->where('id_user', $userId)
            ->update(['status' => 'C']);

        return redirect('/patient/dashboard');
    }

    public function getDoctorShifts(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date');

        // Tarik jadwal shift dokter dari database
        $schedules = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->whereDate('schedule_date', $date)
            ->get();

        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $start = '08:00'; $end = '14:00';
            $sName = strtolower($schedule->shift);
            
            // SINKRONISASI DENGAN JAM ADMIN
            if (str_contains($sName, 'morning')) { $start = '08:00'; $end = '14:00'; }
            elseif (str_contains($sName, 'afternoon')) { $start = '14:00'; $end = '20:00'; }
            elseif (str_contains($sName, 'evening')) { $start = '20:00'; $end = '02:00'; }
            else {
                $parts = explode('-', $schedule->shift);
                if (count($parts) == 2) {
                    $start = trim($parts[0]);
                    $end = trim($parts[1]);
                }
            }

            $bookedTimes = DB::table('appointments')
                ->where('id_schedule', $schedule->id_schedule)
                ->whereDate('appointment_date', $date)
                ->whereIn('status', ['W', 'I'])
                ->pluck('booking_time')
                ->toArray();
                
            $bookedTimes = array_map(function($t) {
                return $t ? date('H:i', strtotime($t)) : null;
            }, $bookedTimes);

            $startTime = strtotime($start);
            $endTime = strtotime($end);

            // PENYELAMAT BUG TENGAH MALAM (Shift Evening)
            if ($endTime <= $startTime) {
                $endTime = strtotime('+1 day', $endTime);
            }

            while ($startTime < $endTime) {
                $timeStr = date('H:i', $startTime);
                $availableSlots[] = [
                    'id_schedule' => $schedule->id_schedule,
                    'time'        => $timeStr,
                    'is_booked'   => in_array($timeStr, $bookedTimes)
                ];
                $startTime = strtotime('+30 minutes', $startTime);
            }
        }

        return response()->json($availableSlots);
    }
}