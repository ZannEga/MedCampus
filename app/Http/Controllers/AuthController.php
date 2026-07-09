<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Models\User;

class AuthController extends Controller
{
    public function registerProcess(Request $request)
    {
        $request->validate([
            'user_name'  => 'required|string',
            'id_user'     => 'required|digits:9|unique:users,id_user',
            'user_email' => 'required|email|unique:users,user_email',
            'password'   => 'required|min:6|confirmed',
        ]);

        \DB::table('users')->insert([
            'id_user'    => $request->id_user,  
            'user_name'  => $request->user_name,
            'user_email' => $request->user_email,
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::validate(['user_email' => $credentials['email'], 'password' => $credentials['password']])) {
            
            $user = \App\Models\User::where('user_email', $credentials['email'])->first();

            if ($user->user_status === 'suspended') {
                return back()->withErrors(['msg' => 'Akses Ditolak: Akun Anda sedang ditangguhkan (Suspended). Silakan hubungi Admin.']);
            }

            if ($user->id_role == '3') {
                \Auth::login($user);
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }

            \Auth::login($user);
            $request->session()->regenerate();

            if ($user->id_role == '2') {
                return redirect('/doctor/dashboard');
            }

            return redirect('/patient/dashboard');
        }

        return back()->withErrors(['msg' => 'Email atau Password salah!']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp_code' => 'required']);

        $userId = $request->session()->get('temp_user_id');
        
        if (!$userId) {
            return redirect('/login');
        }

        $user = \App\Models\User::where('id_user', $userId)->first();

        if ($user && $user->otp_code == $request->otp_code && $user->otp_expires_at > now()) {
            
            \Auth::login($user);
            $request->session()->regenerate();
            
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();
            $request->session()->forget('temp_user_id');

            if ($user->id_role == '3') {
                return redirect('/admin/dashboard');
            } elseif ($user->id_role == '2') {
                return redirect('/doctor/dashboard');
            }

            return redirect('/patient/dashboard');
        }

        return back()->with('error', 'Kode OTP salah atau sudah kedaluwarsa!');
    }
}