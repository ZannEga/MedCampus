<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    // Fungsi Menampilkan Daftar Obat
    public function index()
    {
        $medicines = DB::table('medicines')->orderBy('created_at', 'desc')->get();
        
        // Menghitung metrik untuk kartu statistik di atas
        $totalMeds = $medicines->count();
        // Menggunakan batas < 20 karena sesuai dengan logika "low_stock" di fungsi store Anda
        $lowStock = $medicines->where('stock', '<', 20)->where('stock', '>', 0)->count();
        $outOfStock = $medicines->where('stock', '<=', 0)->count();

        return view('admin-inventory', compact('medicines', 'totalMeds', 'lowStock', 'outOfStock'));
    }

    // Fungsi Menyimpan Obat Baru
    public function store(Request $request)
    {
        // Penentuan status secara otomatis berdasarkan jumlah stok
        $status = 'in_stock';
        if ($request->stock <= 0) {
            $status = 'out_of_stock';
        } elseif ($request->stock < 20) {
            $status = 'low_stock';
        }

        DB::table('medicines')->insert([
            'id_med'       => 'MED' . rand(100000, 999999), 
            'med_name'     => $request->name,
            'med_unit'     => $request->unit,
            'stock'        => $request->stock,
            'med_category' => $request->category,
            'status'       => $status, // Disimpan ke kolom status di pangkalan data
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect('/admin/inventory')->with('success', 'Data obat baru berhasil ditambahkan ke dalam sistem.');
    }

    // Fungsi Menampilkan Formulir Ubah Obat
    public function edit($id)
    {
        $medicine = DB::table('medicines')->where('id_med', $id)->first();
        
        if (!$medicine) {
            return redirect('/admin/inventory')->with('error', 'Data obat tidak ditemukan.');
        }

        return view('admin-medicine-edit', compact('medicine'));
    }

    // Fungsi Memperbarui Data Obat
    public function update(Request $request, $id)
    {
        // Penentuan ulang status apabila stok diubah
        $status = 'in_stock';
        if ($request->stock <= 0) {
            $status = 'out_of_stock';
        } elseif ($request->stock < 20) {
            $status = 'low_stock';
        }

        DB::table('medicines')->where('id_med', $id)->update([
            'med_name'     => $request->name,
            'med_unit'     => $request->unit,
            'stock'        => $request->stock,
            'med_category' => $request->category,
            'status'       => $status,
            'updated_at'   => now(),
        ]);

        return redirect('/admin/inventory')->with('success', 'Update data obat berhasil disimpan.');
    }

    // Fungsi Menghapus Data Obat
    public function destroy($id)
    {
        DB::table('medicines')->where('id_med', $id)->delete();
        return redirect('/admin/inventory')->with('success', 'Data obat berhasil dihapus dari inventaris.');
    }
}