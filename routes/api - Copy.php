<?php

use App\Models\Adjacency;
use App\Models\Page;
use App\Models\Profil;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', function (Request $request) {
    // $domain = $request->getHost();

    // // Cari Dinas berdasarkan domain
    // $dinas = Profil::where('domain', $domain)->first();

    // // dd($domain);

    // if (!$dinas) {
    //     return response()->json(['message' => 'Dinas not found'], 404);
    // }

    // // Ambil post berdasarkan dinas_id
    // $posts = Profil::where('id', $dinas->id)->get();
    // $page = Page::where('idprofil', $dinas->id)->get();

    // // Menggunakan dinas_id dari database
    // $url = "https://skm.bandungkab.go.id/api/showIKM";
    // $client = new Client();

    // try {
    //     // Data yang dikirim dalam body request
    //     $data = [
    //         'dinas_id' => $dinas->ikm_dinas_id
    //     ];

    //     // Mengirim request POST ke API eksternal
    //     $response = $client->request('POST', $url, [
    //         'form_params' => $data
    //     ]);

    //     // Mendapatkan isi respon
    //     $getIKM = json_decode($response->getBody(), true);

    //     // Cek apakah decoding JSON berhasil
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         Log::error('Error decoding JSON: ' . json_last_error_msg());
    //         return response()->json(['message' => 'Error decoding JSON'], 500);
    //     }

    //     // Cek apakah data tersedia
    //     if (empty($getIKM)) {
    //         Log::warning('No data available from API');
    //         return response()->json(['message' => 'No data available'], 404);
    //     }

    // } catch (\Exception $e) {
    //     Log::error('Error fetching data from API: ' . $e->getMessage());
    //     return response()->json(['message' => 'Failed to fetch data from API'], 500);
    // }

    // return response()->json([
    //     'posts'=>$posts,
    //     'page'=>$page,
    //     'ikm' => $getIKM
    //     ]);

    $domain = $request->getHost();
    $referer = $request->headers->get('x-custom-header');

    Log::info('Request Domain: ' . $domain);
    Log::info('Request Referer: ' . $referer);
    Log::info('All Headers: ' . json_encode($request->headers->all()));


    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    $pages = Page::where('idprofil', $dinas->id)->get();

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found for domain: ' . $referer], 404);
    }

    return response()->json([
        'dinas' => $dinas,
        'pages' => $pages ?? [],
    ]);
})->middleware('auth:sanctum');