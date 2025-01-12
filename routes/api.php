<?php

use App\Models\Adjacency;
use App\Models\Page;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', function (Request $request) {
    $domain = $request->getHost();

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $domain)->first();

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }

    // Ambil post berdasarkan dinas_id
    $posts = Profil::where('id', $dinas->id)->get();
    $page = Page::where('idprofil', $dinas->id)->get();

    return response()->json([
        'posts'=>$posts,
        'page'=>$page
        ]);
})->middleware('auth:sanctum');