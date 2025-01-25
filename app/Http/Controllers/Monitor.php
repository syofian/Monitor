<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini
use Illuminate\Http\Request;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;



class Monitor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ProductCode = $request->input('ProductCode');  // Ambil nilai nama dari form
       
        $startDate ="2020-01-01 00:00:00";
        $endDate ="2026-01-01 00:00:00";
        
        if (!empty($ProductCode)) {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $test = DB::connection('mongodb')
            ->collection('VoucherUsages')
            ->raw(function ($collection) use ($ProductCode, $startDate, $endDate) {
                return $collection->aggregate([
                    ['$match' => ['ProductCode' => $ProductCode,
                    'Claimed' => true,
                    'usedAt' => [
                        '$gte' => $startDate,
                        '$lte' => $endDate
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
        } else {
            // Jika nama kosong, ambil semua data
            $test = DB::connection('mongodb')
        ->collection('VoucherUsages')
        ->raw(function ($collection) use ($ProductCode) {
            return $collection->aggregate([
                ['$match' => ['Claimed' => true
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
        }

      
       
       
    
    $test = iterator_to_array($test); // Konversi Cursor MongoDB ke Array

        return view('monitor', ['data' => $test]);
    }


    public function show(Request $request,$id)
    {
        $tgl1 = $request->input('tgl1');  
        $tgl2 = $request->input('tgl2');

    
        // Cek apakah nama kosong atau tidak
        if (!empty($tgl1 && $tgl2)) {
            // Jika nama diisi, lakukan pencarian berdasarkan nama
            $test = DB::connection('mongodb')
                ->collection('VoucherUsages')
                ->where('ProductCode',$id) 
                ->get();
        } else {
            $test = DB::connection('mongodb')
            ->collection('VoucherUsages')
            ->where('ProductCode',$id)  // Filter berdasarkan input nama
            ->get();
        }

       
    
        // Kirim data ke view 'monitor'
        return view('detail', compact('test'));
    }

}
