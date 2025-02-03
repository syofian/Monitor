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
        $status = $request->input('status');  // Ambil nilai nama dari form

        $startDate = $request->input('date1');  
        $endDate =  $request->input('date2'); 
        $startDateUTC = new UTCDateTime(strtotime($startDate) * 1000); // Konversi ke milidetik
        $endDateUTC = new UTCDateTime(strtotime($endDate) * 1000); // Konversi ke milidetik
        
        if (!empty($ProductCode)) {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $test = DB::connection('mongodb')
            ->collection('VoucherUsages')
            ->raw(function ($collection) use ($ProductCode, $startDateUTC, $endDateUTC, $status) {
                return $collection->aggregate([
                    ['$match' => ['ProductCode' => $ProductCode,
                    'Claimed' => $status === 'true' ? true : false,
                    'UsedAt' => [
                        '$gte' => $startDateUTC,  // Filter mulai tanggal
                        '$lte' => $endDateUTC     // Filter sampai tanggal
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
                    ]],
                    [
                        '$sort' => [
                            'total_count' => 1 // Urutkan berdasarkan total_cashback secara menurun
                        ]
                    ]

                ]);
            });
        } else {
            // Jika nama kosong, ambil semua data
            $test = DB::connection('mongodb')
        ->collection('VoucherUsages')
        ->raw(function ($collection) use ($ProductCode) {
            return $collection->aggregate([
                // ['$match' => ['Claimed' => true
                // ]], // Filter berdasarkan ProductCode
                ['$group' => [
                    '_id' => '$ProductCode',
                    'total_count' => ['$sum' => 1], // Hitung jumlah data
                    'total_cashback' => ['$sum' => '$Cashback'], // Hitung total Cashback
                    'details' => ['$push' => [
                        'Cashback' => '$Cashback',
                        'ResellerCode' => '$ResellerCode'
                    ]]
                ]],
                [
                    '$sort' => [
                        'total_count' => -1 // Urutkan berdasarkan total_cashback secara menurun
                    ]
                ]

            ]);
        });
        }

      
       
       
    
    $test = iterator_to_array($test); // Konversi Cursor MongoDB ke Array

        return view('monitor', ['data' => $test]);
    }


    public function show(Request $request,$id,$tgl1,$tgl2,$status)
    {
         
      
        // $tgl1 = $request->input('tgl1');  
        // $tgl2 = $request->input('tgl2');
        $startutc = new UTCDateTime(strtotime($tgl1) * 1000); // Konversi ke milidetik
        $endutc = new UTCDateTime(strtotime($tgl2) * 1000); // Konversi ke milidetik
    
        // Cek apakah nama kosong atau tidak
        if ($tgl1=='null' && $tgl1=='null') {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $test = DB::connection('mongodb')
            ->collection('VoucherUsages')
            ->where('ProductCode',$id)
            ->where('Claimed',true)  
            ->get();
        } else {
            $test = DB::connection('mongodb')
            ->collection('VoucherUsages')
            ->where('ProductCode',$id)
            ->where('UsedAt','>=',$startutc)
            ->where('UsedAt','<=',$endutc)  
            ->where('Claimed',$status === 'true' ? true : false)  
            ->get();
        }

    //     $id = $request->query('id');  // Mendapatkan parameter 'id'
    // $tgl1 = $request->query('date1');  // Mendapatkan parameter 'tgl1'
    // $tgl2 = $request->query('date2');  // Mendapatkan parameter 'tgl2'
    //     $startDateUTC = new UTCDateTime(strtotime($tgl1) * 1000); // Konversi ke milidetik
    //     $endDateUTC = new UTCDateTime(strtotime($tgl2) * 1000); // Konversi ke milidetik
        
    
        // Kirim data ke view 'monitor'
        return view('detail', compact('test'));
    }

}
