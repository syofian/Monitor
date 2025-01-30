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
     
        $awal = $request->input('awal');  
        $akhir =  $request->input('akhir');

       if (!empty($awal) && !empty($akhir)) {
            $data = DB::connection('sqlsrv')
            ->table('pengirim')
            ->select('kode_reseller','tipe_pengirim', 'pengirim')
            ->where('tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
            ->orderBy('kode_reseller', 'asc')
            ->skip($awal) // OFFSET 0 ROWS
            ->take($akhir) // FETCH NEXT 10 ROWS ONLY
            ->get();
        
        
        } else {
            $data = DB::connection('sqlsrv')
            ->table('pengirim')
            ->select('kode_reseller','tipe_pengirim', 'pengirim')
            ->where('tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
            ->orderBy('kode_reseller', 'asc')
            ->limit(100)
            ->get();
        }
            return view('broad', compact('data'));
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
      
        $data_nama = collect($data)->map(function ($item) {
            return [
                'kode'   => $item[0],   
                'pengirim' => $item[1], 

            ];
        });
        
        return view('showfile', compact('data_nama'));
    
    }

    public function kirimData($awal,$akhir)
    {
        $tempes = Storage::disk('public')->get('tempes.txt');

        $data = DB::connection('sqlsrv')
        ->table('pengirim')
        ->select('kode_reseller','tipe_pengirim', 'pengirim')
        ->where('tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
        ->orderBy('kode_reseller', 'asc')
        ->skip($awal) // OFFSET 0 ROWS
        ->take($akhir) // FETCH NEXT 10 ROWS ONLY
        ->get();
         
        $data_nama = $data->map(function ($item) {
            return [
             
                'kode_reseller' => $item->kode_reseller,
                'pengirim' => $item->pengirim,
            ];
        });
        foreach ($data_nama as $pesData) {
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($pesData['pengirim']);
// $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=' . urlencode($pesData['pengirim']).'&message='. urlencode($tempes) .'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

            // Mengirimkan request GET menggunakan Laravel HTTP Client
            $response = Http::get($url);

            if ($response->successful()) {
                // Jika berhasil, ambil hasilnya
            $result = $response->body(); // Mendapatkan body dari response
            
           if($result === 'Status=5'){
            echo "Permintaan gagal ke {$pesData['kode_reseller']}\n";

           } else{
            echo "Permintaan berhasil ke {$pesData['kode_reseller']}\n";

           }
               
            } else {
                // Jika gagal, tampilkan pesan error
                return response()->json([

                    'message' => 'Gagal mengirim permintaan ke SMS API.',
                ]);
            }
            // sleep(5);
        }
    }

    public function selfKirim($pengirim)
    {
        $tempes = Storage::disk('public')->get('tempes.txt');

        $data = DB::connection('sqlsrv')
        ->table('pengirim')
        ->select('kode_reseller','tipe_pengirim', 'pengirim')
        ->where('tipe_pengirim', '=', 's') // Adding the condition for 'pengirim'
        ->where('pengirim', $pengirim) // Adding the condition for 'pengirim'
        ->orderBy('kode_reseller', 'asc')
        ->get();
         
        $data_nama = $data->map(function ($item) {
            return [
             
                'kode_reseller' => $item->kode_reseller,
                'pengirim' => $item->pengirim,
            ];
        });
        foreach ($data_nama as $pesData) {
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($pesData['pengirim']);
            // $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=' . urlencode($pesData['pengirim']).'&message='. urlencode($tempes) .'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

            // Mengirimkan request GET menggunakan Laravel HTTP Client
            $response = Http::get($url);

            // Cek jika request berhasil
            if ($response->successful()) {
                // Jika berhasil, ambil hasilnya
            $result = $response->body(); // Mendapatkan body dari response
            
           if($result === 'Status=5'){
            echo "Permintaan gagal ke {$pesData['kode_reseller']}\n";

           } else{
            echo "Permintaan berhasil ke {$pesData['kode_reseller']}\n";

           }
               
            } else {
                // Jika gagal, tampilkan pesan error
                return response()->json([

                    'message' => 'Gagal mengirim permintaan ke SMS API.',
                ]);
            }
            // sleep(5);
        }
    }


    public function fileKirim(Request $request)
    {
        // Pastikan file ada sebelum membacanya
        if (!Storage::disk('public')->exists('data_dummy.csv')) {
            return back()->with('error', 'File tidak ditemukan.');
        }
    
        // Baca isi file CSV
        $content = Storage::disk('public')->get('data_dummy.csv');
    
        $tempes = Storage::disk('public')->get('tempes.txt');

        // Pisahkan menjadi array per baris
        $rows = explode("\n", trim($content));
    
        // Ubah setiap baris menjadi array menggunakan str_getcsv
        $data = array_map('str_getcsv', array_filter($rows));  // Mengubah rows menjadi array
        // Mengonversi array ke koleksi Laravel
        $data_nama = collect($data)->map(function ($item) {
            return [
                'kode'   => $item[0],    
                'pengirim' => $item[1], 
            ];
        });
        
        $urls = []; // Array untuk menyimpan URL
        
        // Mengumpulkan URL
        foreach ($data_nama as $pesData) {
            $url = "http://localhost:3000/input-nama?nama=" . urlencode($pesData['pengirim']);
            // $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=' . urlencode($pesData['pengirim']).'&message='. urlencode($tempes) .'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

            $urls[] = $url;
        }
        
        $results = []; // Untuk menyimpan hasil response
        
        // Mengirim permintaan untuk setiap URL
        foreach ($urls as $url) {
            $response = Http::get($url);
        
            // Cek jika request berhasil
            if ($response->successful()) {
                // Jika berhasil, ambil hasilnya
            $result = $response->body(); // Mendapatkan body dari response
            
           if($result === 'Status=5'){
            echo "Permintaan gagal ke {$pesData['kode']}\n";

           } else{
            echo "Permintaan berhasil ke {$pesData['kode']}\n";

           }
               
            } else {
                // Jika gagal, tampilkan pesan error
                return response()->json([

                    'message' => 'Gagal mengirim permintaan ke SMS API.',
                ]);
            }
        }
    
    }

    public function fileManual(Request $request, $pengirim)
{
    // Pastikan file ada sebelum membacanya
    if (!Storage::disk('public')->exists('data_dummy.csv')) {
        return back()->with('error', 'File tidak ditemukan.');
    }

    // Baca isi file CSV
    $content = Storage::disk('public')->get('data_dummy.csv');

    // template untuk pesan
    $tempes = Storage::disk('public')->get('tempes.txt');


    // Pisahkan menjadi array per baris
    $rows = explode("\n", trim($content));

    // Ubah setiap baris menjadi array menggunakan str_getcsv
    $data = array_map('str_getcsv', array_filter($rows));  // Mengubah rows menjadi array
    
    // Filter data berdasarkan pengirim (kolom 1 adalah nama)
    $hasil = array_filter($data, function ($item) use ($pengirim) {
        return isset($item[1]) && strtolower($item[1]) === strtolower($pengirim); // Pengirim di kolom 3
    });

    // Ambil header (baris pertama) jika perlu
    $header = array_shift($data);

    // Map data yang difilter
    $data_nama = collect($hasil)->map(function ($item) {
        return [
            'kode'   => $item[0],   // Ambil kode dari index ke-0
            'pengirim' => $item[1], // Ambil pengirim dari index ke-3
        ];
    });

    $urls = []; // Array untuk menyimpan URL

    // Mengumpulkan URL
    foreach ($data_nama as $pesData) {
        $url = "http://localhost:3000/input-nama?nama=" . urlencode($pesData['pengirim']);
        // $url ='https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=' . urlencode($pesData['pengirim']).'&message='. urlencode($tempes) .'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2'; 

        $urls[] = $url;
    }

    $results = []; // Untuk menyimpan hasil response

    // Mengirim permintaan untuk setiap URL
    foreach ($urls as $url) {
     
            $response = Http::get($url);

            if ($response->successful()) {
                // Jika berhasil, ambil hasilnya
            $result = $response->body(); // Mendapatkan body dari response

           if($result === 'Status=5'){
            echo "Permintaan gagal ke {$pesData['kode']}\n";

           } else{
            echo "Permintaan berhasil ke {$pesData['kode']}\n";

           }
               
            } else {
                // Jika gagal, tampilkan pesan error
                return response()->json([

                    'message' => 'Gagal mengirim permintaan ke SMS API.',
                ]);
            }
        } 
    }

    public function import(Request $request)
    {
        // Validasi file yang di-upload
       // Validasi file yang di-upload
       $request->validate([
        'file' => 'required|file|mimes:csv,txt', // Hanya menerima file CSV atau TXT
    ]);

    // Tentukan nama file CSV lama yang akan diganti
    $oldFilePath = 'public/data_dummy.csv'; // Ganti dengan path file CSV yang ingin diganti

    // Hapus file lama jika ada
    if (Storage::exists($oldFilePath)) {
        Storage::delete($oldFilePath);
    }

    // Simpan file CSV baru di folder yang sama
    $newFilePath = $request->file('file')->storeAs('public', 'data_dummy.csv'); // Mengganti dengan nama yang sama

    return back()->with('success', 'File CSV berhasil diganti!');
}
public function tempes(Request $request)
    {
        // Validasi file yang di-upload
       // Validasi file yang di-upload
       $request->validate([
        'file' => 'required|file|mimes:csv,txt', // Hanya menerima file CSV atau TXT
    ]);

    // Tentukan nama file CSV lama yang akan diganti
    $oldFilePath = 'public/tempes.txt'; // Ganti dengan path file CSV yang ingin diganti

    // Hapus file lama jika ada
    if (Storage::exists($oldFilePath)) {
        Storage::delete($oldFilePath);
    }

    // Simpan file CSV baru di folder yang sama
    $newFilePath = $request->file('file')->storeAs('public', 'tempes.txt'); // Mengganti dengan nama yang sama

    return back()->with('success', 'File txt berhasil diganti!');
}

}
