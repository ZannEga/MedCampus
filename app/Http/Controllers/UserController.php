<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilan Tabel (Directory)
    public function index()
    {
        $users = DB::table('users')->whereNull('deleted_at')->get();
        return view('admin-users', compact('users'));
    }

    // Tampilan Form Add
    public function create()
    {
        return view('admin-user-add');
    }

    public function store(Request $request)
    {
        // 1. Logika Prefix ID
        $prefix = $request->role === 'Doctor' ? 'MC' : ($request->role === 'Admin' ? 'ADM' : 'ST');
        $newId = $prefix . '-' . rand(100000, 999999);

        // 2. Terjemahkan teks Role jadi Angka ID
        $roleId = 1; // Default buat Student
        if ($request->role === 'Doctor') $roleId = 2;
        if ($request->role === 'Admin') $roleId = 3;

        $request->validate([
            'email' => 'required|email|unique:users,user_email',
        ], [
            'email.unique' => 'Alamat surel ini sudah terdaftar di sistem, termasuk pada akun yang telah diarsipkan.'
        ]);

        // 3. Insert ke Database pake $roleId (berupa angka)
        DB::table('users')->insert([
            'id_user'     => $newId,
            'user_name'   => $request->name,
            'user_email'  => $request->email,
            'user_phone'  => $request->phone,
            'id_role'     => $roleId,
            'user_dept'   => $request->department,
            'user_status' => 'active',
            'password'    => Hash::make($request->password),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect('/admin/users')->with('success', 'User berhasil didaftarkan!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id_user', $id)->update([
            'deleted_at'  => now(),
            'user_status' => 'suspended',
            'updated_at'  => now()
        ]);

        return redirect('/admin/users')->with('success', 'Pengguna berhasil dihapus secara aman dari sistem!');
    }

    // 1. Fungsi buat nampilin halaman Edit beserta data user yang dipilih
    public function edit(Request $request)
    {
        $id = $request->query('id'); // Nangkap ID dari URL (?id=ST-547141)
        $user = DB::table('users')->where('id_user', $id)->first();

        if (!$user) {
            return redirect('/admin/users')->with('error', 'User tidak ditemukan!');
        }

        return view('admin-user-edit', compact('user'));
    }

    // 2. Fungsi buat nyimpen data yang diedit ke HeidiSQL
    public function update(Request $request, $id)
    {
        // Terjemahin teks Role jadi Angka ID (kayak pas Add User)
        $roleId = 1; // Default Student
        if ($request->role === 'Doctor') $roleId = 2;
        if ($request->role === 'Admin') $roleId = 3;

        DB::table('users')->where('id_user', $id)->update([
            'user_name'   => $request->name,
            'user_email'  => $request->email,
            'user_phone'  => $request->phone,
            'id_role'     => $roleId,
            'user_dept'   => $request->department,
            'user_status' => $request->status, // Ini yang nangkep status "on-leave"
            'updated_at'  => now(),
        ]);

        return redirect('/admin/users')->with('success', 'Profile berhasil diupdate!');
    }
}