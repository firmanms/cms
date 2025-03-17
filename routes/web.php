<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'beranda']);
Route::get('/beranda', [FrontendController::class, 'beranda']);
Route::get('/page/statis/blog', [FrontendController::class, 'blog']);
Route::get('/page/statis/blogkategori/{slug}', [FrontendController::class, 'blogkategori']);
Route::get('/page/{slug}', [FrontendController::class, 'singlepage'])->name('singlepage');
Route::get('/detailblog/{slug}', [FrontendController::class, 'blogdetail'])->name('blogdetail');
Route::get('/page/statis/galeri', [FrontendController::class, 'galeri']);
Route::get('/detailgaleri/{slug}', [FrontendController::class, 'galeridetail'])->name('galeridetail');
Route::get('/page/statis/layanan', [FrontendController::class, 'layanan']);
Route::get('/page/statis/sarana', [FrontendController::class, 'sarana']);
Route::get('/page/statis/pengaduan', [FrontendController::class, 'pengaduan']);
Route::get('/page/statis/skm', [FrontendController::class, 'skm']);
Route::get('/page/statis/produkhukum', [FrontendController::class, 'produkhukum'])->name('produkhukum');
Route::get('/page/statis/dokumenupload', [FrontendController::class, 'dokumenupload'])->name('dokumenupload');;

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});
