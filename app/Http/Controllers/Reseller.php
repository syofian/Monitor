<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;



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
            ->get();
        } else {
            $data = DB::connection('mongodb')
            ->collection('reseller')
            ->where('IsFullyVerified',false )
            ->where('IsVerified',false )
            ->where('VerificationStage','=',2 )
            ->get();
        }
        
        return view('Reseller/reseller', compact('data'));
    }


    public function show(Request $request,$id,$tgl1,$tgl2)
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
            ->where('Claimed',true)  
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
