<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalUsers = DB::table('users')->count();
        $activeUsers = DB::table('users')->where('user_status', 'active')->count();

        $totalMeds = DB::table('medicines')->count();
     
        $lowStockMeds = DB::table('medicines')->where('stock', '<', 10)->count(); 

        $totalScheds = DB::table('doctor_schedules')->count();

        $recentUsers = DB::table('users')->orderBy('created_at', 'desc')->limit(5)->get();

        $deptDistribution = DB::table('doctor_schedules')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select('users.user_dept', DB::raw('count(*) as count'))
            ->groupBy('users.user_dept')
            ->get();

        return view('admin-dashboard', compact(
            'totalUsers', 'activeUsers', 
            'totalMeds', 'lowStockMeds', 
            'totalScheds', 'recentUsers', 
            'deptDistribution'
        ));
    }
}