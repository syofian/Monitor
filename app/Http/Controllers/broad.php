<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class broad extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('date1');  
        $endDate =  $request->input('date2');
        $kode =  $request->input('kode');

        if (!empty($startDate)) { 
            $data = DB::connection('sqlsrv')
            ->table('reseller')
            ->select('reseller.nama', 'reseller.kode', 'reseller.alamat', 'pengirim.pengirim')
            ->join('pengirim', 'reseller.kode', '=', 'pengirim.kode_reseller') 
            ->where('reseller.tgl_aktivitas', '>', $startDate)  
            ->where('reseller.tgl_aktivitas', '<', $endDate)
            ->where('reseller.aktif', 1)
            ->where('pengirim.tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
            ->distinct() 
            ->get();
        
        } else {
            $data = DB::connection('sqlsrv')
            ->table('reseller')
            ->select('reseller.nama', 'reseller.kode', 'reseller.alamat', 'pengirim.pengirim')
            ->join('pengirim', 'reseller.kode', '=', 'pengirim.kode_reseller')    
            ->distinct('kode')
            ->where('reseller.aktif', 1)
            ->where('pengirim.tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
            ->limit('100')
            ->get();
        }
            return view('broad', compact('data'));
    }

   

    public function kirimData($startDate,$endDate)
    {
        $data = DB::connection('sqlsrv')
        ->table('reseller')
        ->select('reseller.nama', 'reseller.kode', 'reseller.alamat', 'pengirim.pengirim')
        ->join('pengirim', 'reseller.kode', '=', 'pengirim.kode_reseller') 
        ->distinct('kode')
        ->where('tgl_aktivitas', '>', $startDate)  
        ->where('tgl_aktivitas', '<', $endDate)
        ->where('pengirim.tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
        ->where('reseller.aktif', 1)
        // ->limit('1')
        ->get();
         
        $data_nama = $data->map(function ($item) {
            return [
                'nama' => $item->nama,
                'kode' => $item->kode,
                'pengirim' => $item->pengirim,
            ];
        });
        foreach ($data_nama as $nama) {
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($nama['pengirim']);
// $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=+6283197187703&message=' . urlencode($nama['nama']).'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

            // Mengirimkan request GET menggunakan Laravel HTTP Client
            $response = Http::get($url);

            // Cek jika request berhasil
            if ($response->successful()) {
                echo "Permintaan berhasil.\n";
            } else {
                echo "Terjadi masalah saat mengirim permintaan .\n";
            }
            // sleep(5);
        }
    }

    public function selfKirim($kode)
    {
        $data = DB::connection('sqlsrv')
        ->table('reseller')
        ->select('reseller.nama', 'reseller.kode', 'reseller.alamat', 'pengirim.pengirim')
        ->join('pengirim', 'reseller.kode', '=', 'pengirim.kode_reseller') 
        ->distinct('kode')
        ->where('pengirim.pengirim',$kode)  
        ->where('pengirim.tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
        ->where('reseller.aktif', 1)
        // ->limit('1')
        ->get();
         
        $data_nama = $data->map(function ($item) {
            return [
                'nama' => $item->nama,
                'kode' => $item->kode,
                'pengirim' => $item->pengirim,
            ];
        });
        foreach ($data_nama as $nama) {
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($nama['pengirim']);
// $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=+6283197187703&message=' . urlencode($nama['nama']).'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

            // Mengirimkan request GET menggunakan Laravel HTTP Client
            $response = Http::get($url);

            // Cek jika request berhasil
            if ($response->successful()) {
                echo "Permintaan berhasil.\n";
            } else {
                echo "Terjadi masalah saat mengirim permintaan .\n";
            }
            // sleep(5);
        }
    }

    public function showfile(Request $request)
    {
        // Pastikan file ada sebelum membacanya
        if (!Storage::disk('public')->exists('data_dummy.csv')) {
            return back()->with('error', 'File tidak ditemukan.');
        }
    
        // Baca isi file CSV
        $content = Storage::disk('public')->get('data_dummy.csv');
    
        // Pisahkan menjadi array per baris
        $rows = explode("\n", trim($content));
    
        // Ubah setiap baris menjadi array menggunakan str_getcsv
        $data = array_map('str_getcsv', array_filter($rows));  // Mengubah rows menjadi array
    
        $header = array_shift($data);

        // Ambil hanya kolom Nama (asumsi Nama ada di index ke-2)
        // $data_nama = array_column($data,);

        // Mengonversi array ke koleksi Laravel
        $data_nama = collect($data)->map(function ($item) {
            return [
                'nama'   => $item[2],   // Ambil nama dari index ke-2
                'kode'   => $item[1],   // Ambil kode dari index ke-1
                'pengirim' => $item[0], // Ambil pengirim dari index ke-0
            ];
        });
        
        foreach ($data_nama as $dta) {
         
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($dta['nama']);

        }
        
        // Menampilkan hasil
        dd($url); // Menampilkan array URL
        // Kirimkan ke view
        // return view('showfile', compact('header', 'data_nama'));
    
    }

}
