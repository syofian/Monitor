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

}
