<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CrudResellerMongo extends Controller
{
    public function index(Request $request)
    {  
        $Kode = $request->input('Kode');

        if (!empty($Kode)) {
            $data = DB::connection('mongodb')
            ->collection('reseller')
            ->where('Kode',$Kode)
            ->get();
        } else {
            $data = DB::connection('mongodb')
            ->collection('reseller')
            ->limit('100')
            ->get();

        }

        
            return view('CrudResellerMongo/crudReseller', compact('data'));
}

public function edit(Request $request, $id)
{
    
    DB::connection('mongodb')
        ->collection('reseller')
        ->where('Kode', $id)
        ->update([
            'Pin' => $request->input('Pin'),
        ]);

    return redirect()->back()->with('success', 'Pesan updated successfully!');
}


}
