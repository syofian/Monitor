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
        $oneMonthAhead = $now->copy()->addMonth(); // Tambahkan satu bulan ke tanggal saat ini
        $lastYear = $oneMonthAhead->copy()->subMonths(12); // Kurangi satu tahun dari tanggal satu bulan ke depan


        $totalDivisi = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as formatted_date"), DB::raw('COUNT(kode) as kode'))
        ->where('tgl_aktivitas', '>', $lastYear->startOfMonth())
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('formatted_date', 'asc')
        ->limit(30)
        ->pluck('kode');
    

        $divisi = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as formatted_date"))
        ->where('tgl_aktivitas', '>', $lastYear->startOfMonth())
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('formatted_date', 'asc')
        ->limit(30)
        ->pluck('formatted_date');

        DD($divisi);
    
        return view('Traffic/index', [
            'totalPengguna' => $totalPengguna,
            'totalDivisi' => $totalDivisi,
            'divisi' => $divisi,
        ]);
    }

    
//     public function grafik()
//     {
//        $totalBookingHotel = DB::connection('pgsql')->table('sppd')
//     ->select(DB::raw('COUNT(io_number) as io_count'))
//     ->groupBy(DB::raw('MONTH(start_date)'))
//     ->pluck('io_count');

// $bulan =DB::connection('pgsql')->table('sppd')
//     ->select(DB::raw('MONTHNAME(start_date) as bulan'))
//     ->groupBy(DB::raw('MONTHNAME(start_date)'))
//     ->pluck('bulan');

// $tes = DB::connection('pgsql')->table('sppd')->get();

// // Perbaikan pada bagian ini
// $hasil = response()->json($tes);
// dd($hasil); // Melakukan debug untuk variabel $hasil


//         return view('dashboard.index', compact('totalBookingHotel', 'bulan','hasil'));
//     }
}

