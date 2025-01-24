<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;


class Monitor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ProductCode = $request->input('ProductCode');  // Ambil nilai nama dari form
    
        // Cek apakah nama kosong atau tidak
        // if (!empty($ProductCode)) {
        //     // Jika nama diisi, lakukan pencarian berdasarkan nama
        //     $test = DB::connection('mongodb')
        //         ->collection('VoucherUsages')
        //         ->where('ProductCode', 'like', '%' . $ProductCode . '%')  // Filter berdasarkan input nama
        //         ->get();
        // } else {
        //     // Jika nama kosong, ambil semua data
        //     $test = DB::connection('mongodb')
        //         ->collection('VoucherUsages')
        //         ->get();
        // }

        $startDate = "2020-01-01"; // Tanggal awal
        $endDate = "2024-01-31";   // Tanggal akhir
       
        $test = DB::connection('mongodb')
        ->collection('VoucherUsages')
        ->raw(function ($collection) use ($ProductCode, $startDate, $endDate) {
            return $collection->aggregate([
                ['$match' => ['ProductCode' => $ProductCode,
                'usedAt' => [
                    '$gte' => new UTCDateTime(strtotime($startDate) * 1000),
                    '$lte' => new UTCDateTime(strtotime($endDate) * 1000)
                ]
                ]], // Filter berdasarkan ProductCode
                ['$group' => [
                    '_id' => '$ProductCode',
                    'total_count' => ['$sum' => 1], // Hitung jumlah data
                    'total_cashback' => ['$sum' => '$Cashback'], // Hitung total Cashback
                    'details' => ['$push' => [
                        'Cashback' => '$Cashback',
                        'ResellerCode' => '$ResellerCode'
                    ]]
                ]]
            ]);
        });
    
    $test = iterator_to_array($test); // Konversi Cursor MongoDB ke Array
    
    
    
  
        
        
        
    //    dd($test);
    
        // // Kirim data ke view 'monitor'
        return view('monitor', ['data' => $test]);
    }


    public function show(Request $request,$id)
    {
        // $ProductCode = $request->input('ProductCode');  // Ambil nilai nama dari form
    
        // // Cek apakah nama kosong atau tidak
        // if (!empty($ProductCode)) {
        //     // Jika nama diisi, lakukan pencarian berdasarkan nama
        //     $test = DB::connection('mongodb')
        //         ->collection('VoucherUsages')
        //         ->where('ProductCode', 'like', '%' . $ProductCode . '%')  // Filter berdasarkan input nama
        //         ->get();
        // } else {
        //     // Jika nama kosong, ambil semua data
        //     $test = DB::connection('mongodb')
        //         ->collection('VoucherUsages')
        //         ->get();
        // }

        $test = DB::connection('mongodb')
        ->collection('VoucherUsages')
        ->where('ProductCode',$id)  // Filter berdasarkan input nama
        ->get();
    
        // Kirim data ke view 'monitor'
        return view('detail', compact('test'));
    }

}
