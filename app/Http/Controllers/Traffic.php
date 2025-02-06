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
    public function index(Request $request)
    {
      
        $totalPengguna = DB::connection('sqlsrv')->table('reseller')->distinct()->count('kode');
        $now = now(); // Mendapatkan tanggal dan waktu saat ini
        // $oneMonthAhead = $now->copy()->addMonth(); // Tambahkan satu bulan ke tanggal saat ini
        // $lastYear = $oneMonthAhead->copy()->subMonths(12); // Kurangi satu tahun dari tanggal satu bulan ke depan
        $startDate = $request->input('startDate');  
        $endDate =  $request->input('endDate');

       if (!empty($startDate) && !empty($endDate)) {
        $date1 = Carbon::createFromFormat('Y-m-d', $startDate);
        $date2 = Carbon::createFromFormat('Y-m-d', $endDate);
        $diff = $date1->diffInDays($date2);
        $total = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as tgl"), DB::raw('COUNT(kode) as jml'))
        ->where('tgl_aktivitas','>=', $startDate)  // `now()` akan mengambil waktu saat ini
        ->where('tgl_aktivitas','<=',$endDate)  // `now()` akan mengambil waktu saat ini
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('tgl', 'desc')
        ->limit($diff)
        ->get()->toArray(); // Mengonversi hasil ke array
        
       } else {

        $total = DB::connection('sqlsrv')->table('reseller')
        ->select(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd') as tgl"), DB::raw('COUNT(kode) as jml'))
        ->where('tgl_aktivitas', '<', now())  // `now()` akan mengambil waktu saat ini
        ->groupBy(DB::raw("FORMAT(tgl_aktivitas, 'yyyy-MM-dd')"))
        ->orderBy('tgl', 'desc')
        ->limit(10)
        ->get()->toArray(); // Mengonversi hasil ke array
       }
    
        return view('Traffic/index', [
            'total' => $total,
        ]);
    }

 
}

