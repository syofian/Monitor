<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

class broad extends Controller
{
    public function index()
    {
        $data = DB::connection('sqlsrv')
        ->table('reseller')
        ->select('nama', 'kode', 'alamat', 'nomor_hp')
        ->distinct('kode')
        ->where('aktif', 1)
        ->limit('100')
        ->get();

    

            return view('broad', compact('data'));
    }

    public function postData(Request $request)
    {
        // URL API yang ingin dituju
        // $url = 'https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=0895424010064&message=selamatdata&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2';  // Ganti dengan URL API yang sesuai

        // Data yang akan dikirim (dari request atau data yang diinginkan)
        // $data = [
        //     'nama' => $request->input('nama')
        // ];

        $msisdn = $request->input('msisdn');
        $message = $request->input('message'); // Default message jika tidak ada input

        // URL API yang ingin dituju dengan msisdn yang dinamis
        // $url = 'https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn=' . $msisdn . '&message=' . $message . '&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2';

        $url = 'https://sms-api.jatismobile.com/index.ashx?userid=jayawisata&password=jayawisata123&msisdn='. $msisdn .'&message='. $message .'&sender=KARVELO&division=AJW&batchname=willy&uploadby=willy&channel=2';  // Ganti dengan URL API yang sesuai


        // Inisialisasi Guzzle HTTP Client
        $client = new Client();

        // try {
            // Mengirim data dengan metode POST
            $response = $client->post($url);

            // Mengambil respons dari API
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Menampilkan respons di view
            return view('tes', ['response' => $responseData]);
          

        // } catch (RequestException $e) {
        //     // Jika terjadi error, tampilkan pesan error
            return view('tes', ['error' => 'Error occurred while sending data', 'message' => $e->getMessage()]);
        // }
    }
}
