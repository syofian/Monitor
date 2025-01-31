<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use App\Exports\UsersExport; // Pastikan Anda juga mengimpor UsersExport


class Reseller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('date1');  
        $endDate =  $request->input('date2'); 

        $startDateUTC = new UTCDateTime(strtotime($startDate) * 1000); // Konversi ke milidetik
        $endDateUTC = new UTCDateTime(strtotime($endDate) * 1000); // Konversi ke milidetik
        
        
        // Membuat objek UTCDateTime untuk query
        if (!empty($startDate)) {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $data = DB::connection('mongodb')
            ->collection('reseller')
            ->where('TglAktifitas', '>', $startDateUTC)
            ->where('TglAktifitas', '<', $endDateUTC)
            ->where('IsFullyVerified',false )
            ->where('IsVerified',false )
            ->where('VerificationStage','=',2 )
            ->where('KTPValidated',false )
            ->where('SelfieValidated',false )
            ->get();
        } else {
            $data = DB::connection('mongodb')
            ->collection('reseller')
            ->where('IsFullyVerified',false )
            ->where('IsVerified',false )
            ->where('VerificationStage','=',2 )
            ->where('KTPValidated',false )
            ->where('SelfieValidated',false )
            ->orderby('Kode','asc')
            ->get();
        }
        
        return view('Reseller/reseller', compact('data'));
    }


    public function exportResellerData()
{
    try {
        // Ambil data menggunakan query dengan cursor
        $data = DB::connection('mongodb')
                  ->collection('reseller')
                  ->where('IsFullyVerified', false)
                  ->where('IsVerified', false)
                  ->where('VerificationStage', 2)
                  ->where('KTPValidated', false)
                  ->where('SelfieValidated', false)
                  ->orderby('Kode', 'asc')
                  ->cursor(); // Menggunakan cursor untuk menghindari load data ke memori sekaligus

        // Buat file CSV
        $filename = 'Data Verifikasi ' . now()->format('Y_m_d_H_i_s') . '.csv';
        $handle = fopen('php://output', 'w');

        // Set header untuk download CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Output header CSV (hanya sekali)
        fputcsv($handle, ['Kode', 'Nama', 'Kode Level']);

        // Loop data reseller dan tambahkan ke CSV
        foreach ($data as $reseller) {
            // Pastikan untuk menambahkan data dengan format yang benar
            fputcsv($handle, [
                $reseller['Kode'],        // Jika menggunakan MongoDB dengan field objek
                $reseller['Nama'],        // Jika fieldnya adalah 'Nama'
                $reseller['KodeLevel'],   // Jika fieldnya adalah 'KodeLevel'
            ]);
        }

        fclose($handle);
        exit;

    } catch (\Exception $e) {
        // Menangani error jika terjadi masalah
        Log::error('Error exporting to CSV: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}
}

