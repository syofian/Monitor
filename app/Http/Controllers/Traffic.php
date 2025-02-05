<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\role_akses;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Charts\UserChart;




class Traffic extends Controller
{
    /**
     * Show a list of all of the application's users.
     */
    public function index()
    {
        
      
        $totalPengguna = DB::connection('sqlsrv')->table('reseller')->distinct()->count('kode');
        $now = now(); // Mendapatkan tanggal dan waktu saat ini
        // $oneMonthAhead = $now->copy()->addMonth(); // Tambahkan satu bulan ke tanggal saat ini
        // $lastYear = $oneMonthAhead->copy()->subMonths(12); // Kurangi satu tahun dari tanggal satu bulan ke depan


        $total = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as tgl"), DB::raw('COUNT(kode) as jml'))
        ->where('tgl_aktivitas', '<', now())  // `now()` akan mengambil waktu saat ini
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('tgl', 'desc')
        ->limit(15)
        ->get()->toArray(); // Mengonversi hasil ke array

        $pengguna = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as formatted_date"))
        ->where('tgl_aktivitas', '<', $now)
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('formatted_date', 'desc')
        ->limit(15)
        ->pluck('formatted_date');

        return view('Traffic/index', [
            'total' => $total,
            'pengguna' => $pengguna,
        ]);
    }

 
}

