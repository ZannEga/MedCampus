<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = DB::table('doctor_schedules')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select('doctor_schedules.*', 'users.user_name', 'users.user_dept')
            ->orderBy('schedule_date', 'asc')
            ->get();

        return view('admin-schedules', compact('schedules'));
    }

    public function create()
    {
        // Hanya mengambil user dengan role dokter (id_role = 2)
        $doctors = DB::table('users')->where('id_role', 2)->get();
        return view('admin-schedule-add', compact('doctors'));
    }

    public function store(Request $request)
    {
        DB::table('doctor_schedules')->insert([
            'id_schedule'   => 'SCH-' . rand(1000, 9999),
            'id_user'       => $request->doctor_id,
            'schedule_date' => $request->date,
            'shift'         => $request->shift,
            'room'          => $request->room,
            'notes'         => $request->notes,
            'quota'         => 30,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect('/admin/schedules')->with('success', 'Jadwal dokter berhasil dikonfigurasi.');
    }


    public function edit($id)
    {
        $schedule = DB::table('doctor_schedules')->where('id_schedule', $id)->first();
        $doctors = DB::table('users')->where('id_role', 2)->get();
        
        return view('admin-schedule-edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        DB::table('doctor_schedules')->where('id_schedule', $id)->update([
            'id_user'       => $request->doctor_id,
            'schedule_date' => $request->date,
            'shift'         => $request->shift,
            'room'          => $request->room,
            'notes'         => $request->notes,
            'updated_at'    => now(),
        ]);

        return redirect('/admin/schedules')->with('success', 'Jadwal dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('doctor_schedules')->where('id_schedule', $id)->delete();
        return redirect('/admin/schedules')->with('success', 'Jadwal dokter berhasil dihapus.');
    }
}