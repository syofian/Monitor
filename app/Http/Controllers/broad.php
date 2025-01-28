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
        // $content = Storage::disk('public')->get('data_dummy.csv');
        // $rows = explode("\n", trim($content));

        // foreach ($rows as $index => $row) {
        //     $data = str_getcsv($row);
        //     if ($index === 0) continue; // Lewati baris header
        
        //     echo $data[2] . "<br>"; // Index 2 = Nama
        // }

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

}
