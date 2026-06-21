<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerProcess(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'uni_id'    => 'required|digits:9|unique:users,id_user',
            'email'     => 'required|email|unique:users,user_email',
            'password'  => 'required|min:6',
        ]);

        $fullName = $request->firstname . ' ' . $request->lastname;

        \DB::table('users')->insert([
            'id_user'    => $request->uni_id,  
            'user_name'  => $fullName,
            'user_email' => $request->email,
            'password'   => \Hash::make($request->password), 
            'id_role'    => '1',               
            'user_phone' => '-', 
            'user_dept'  => 'None', 
            'user_status'=> 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat dengan NIM Anda!');
    }


    public function loginProcess(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Proses Pencocokan Email & Sandi
        if (\Auth::attempt(['user_email' => $credentials['email'], 'password' => $credentials['password']])) {
            
            // 3. Buat Sesi Baru (Biar nggak gampang di-hack)
            $request->session()->regenerate();
            $user = \Auth::user();

            // 🛑 SATPAM GALAK: CEK STATUS SUSPEND DI SINI 🛑
            if ($user->user_status === 'suspended') {
                \Auth::logout(); // Langsung tendang keluar saat itu juga
                $request->session()->invalidate(); // Hapus sesi
                $request->session()->regenerateToken(); // Cegah error keamanan
                
                // Kembalikan ke halaman login dengan pesan error khusus
                return back()->withErrors(['msg' => 'Akses Ditolak: Akun Anda sedang ditangguhkan (Suspended). Silakan hubungi Admin.']);
            }

            // 4. Arahkan ke Dashboard masing-masing jika status AMAN
            if ($user->id_role == '3') {
                return redirect('/admin/dashboard');
            } elseif ($user->id_role == '2') {
                return redirect('/doctor/dashboard');
            }

            // Kalau id_role = 1 (Pasien/Mahasiswa)
            return redirect('/patient/dashboard');
        }

        // Kalau Email/Sandi yang dimasukkan salah
        return back()->withErrors(['msg' => 'Email atau Password salah!']);
    }
}