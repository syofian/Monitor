<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini
use Illuminate\Http\Request;


class Monitor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nama = $request->input('nama');  // Ambil nilai nama dari form
    
        // Cek apakah nama kosong atau tidak
        if (!empty($nama)) {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $test = DB::connection('mongodb')
                ->collection('DataMonitor')
                ->where('Nama', 'like', '%' . $nama . '%')  // Filter berdasarkan input nama
                ->get();
        } else {
            // Jika nama kosong, ambil semua data
            $test = DB::connection('mongodb')
                ->collection('DataMonitor')
                ->get();
        }
    
        // Kirim data ke view 'monitor'
        return view('monitor', compact('test'));
    }

}
