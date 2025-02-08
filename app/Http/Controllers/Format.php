<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Format extends Controller
{
    public function index(Request $request)
    {

            $data  = DB::connection('mongodb')
            ->collection('Formats')
            ->get();
            return view('Format/index', compact('data'));
}

public function editFormat(Request $request, $id)
{
    // $id =  $request->input('id');
    $format =  $request->input('format');
    $data = DB::connection('mongodb')
        ->collection('Formats')
        ->where('_id', $id)
        ->update([
            '_id' => $id,
            'Format' => $format,
            // Add more fields as necessary
        ]);

    return redirect()->route('Format')->with('success', 'Updated successfully!');
}


public function deleteFormat(Request $request, $id)
{
    
    DB::connection('mongodb')
        ->collection('Formats')
        ->where('_id', $id)
        ->delete();

    return redirect()->route('Format')->with('success', 'Updated successfully!');
}

public function addFormat(Request $request)
{
    
   $data = DB::connection('mongodb')
    ->collection('Formats')
    ->insert([
        '_id' => $request->input('id'),  // Assuming 'template' is being passed
        'Format' => $request->input('format'),  // Status set to 1 (active)
       
    ]);

    return redirect()->route('Format')->with('success', 'Updated successfully!');
}


}
