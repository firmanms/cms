<?php

use App\Models\Adjacency;
use App\Models\Agenda;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Employee;
use App\Models\Facilities;
use App\Models\Faq;
use App\Models\Galery;
use App\Models\Page;
use App\Models\Post;
use App\Models\Profil;
use App\Models\Related;
use App\Models\Service;
use App\Models\Slide;
use App\Models\Viewer;
use App\Models\Visitor;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Mencatat pengunjung
    $ipAddress = $request->ip(); // Mendapatkan alamat IP pengunjung
    $visitDate = Carbon::now()->toDateString(); // Mendapatkan tanggal saat ini 
    Visitor::firstOrCreate(
        ['ip_address' => $ipAddress, 'visit_date' => $visitDate],
        ['domain' => $dinas->domain, 'visit_date' => $visitDate]
    );
    $view = Viewer::firstOrCreate(['page' => $dinas->domain],['domain' => $dinas->domain]);
    $view->increment('count'); // Menambah jumlah tampilan

    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }

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

    // Ambil post berdasarkan dinas_id
    $profil          = Profil::where('id', $dinas->id)->first();
    $menu            = Adjacency::where('idprofil', $dinas->id)->first();
    $slide           = Slide::where('idprofil', $dinas->id)->get();
    $posting         = Post::with('categories')->where('idprofil', $dinas->id)->orderBy('published','desc')->get()->take(9);
    $employee        = Employee::where('idprofil', $dinas->id)->get();
    // $posts           = Profil::where('id', $dinas->id)->get();
    $page            = Page::where('idprofil', $dinas->id)->get();
    // $artikel         = Post::where('idprofil', $dinas->id)->get();
    $kategori_banner = Banner::distinct()->get(['kategori']);
    $banner          = Banner::where('idprofil', $dinas->id)->get();
    // Ambil agenda dengan memastikan tidak termasuk yang dipublikasikan kemarin
    $yesterday = Carbon::yesterday()->startOfDay();
    $today = Carbon::today()->startOfDay();
    $agenda = Agenda::where('idprofil', $dinas->id)
                     ->where('published', '>=', value: $today)
                     ->orderBy('published', 'asc')
                     ->get();
    $faq             = Faq::where('idprofil', $dinas->id)->get();
    $relatedlink     = Related::where('idprofil', $dinas->id)->get();

    //visitor
    $today = Carbon::today();
    $dailyVisitors  = Visitor::whereDate('created_at', $today)->where('domain',$dinas->domain)->count();
    $allVisitors    = Visitor::where('domain',$dinas->domain)->count();
    $viewCount      = Viewer::where('domain',$dinas->domain)->first();

    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'             =>$profil,
        'menus'              =>$menus,
        'slide'              =>$slide,
        'posting'            =>$posting,
        'kategori_banner'    =>$kategori_banner,
        'banner'             =>$banner,
        'employee'           =>$employee,
        // 'posts'              =>$posts,
        'page'               =>$page,
        'agenda'             =>$agenda,
        'faq'                =>$faq,
        'relatedlink'        =>$relatedlink,
        
        // 'artikel'   =>$artikel,
        // 'ikm' => [$getIKM],
        'dailyVisitors'=>$dailyVisitors,
        'allVisitors'=>$allVisitors,
        'viewCount'=>$viewCount,
        ]);
})
->middleware('auth:sanctum');

Route::get('/pages', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    $slug = $request->headers->get('x-slug-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);
    // Log::info('Request Referer: ' . $slug);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }

    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $posts = Profil::where('id', $dinas->id)->get();
    $page = Page::where('idprofil', $dinas->id)->where('slug',$slug)->first();
    $artikel = Post::where('idprofil', $dinas->id)->get();

    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'posts'=>$posts,
        'page'=>$page,
        
        'artikel'=>$artikel,
        // 'ikm' => [$getIKM],
        'a'=>'b',
        ]);
})
->middleware('auth:sanctum');

Route::get('/blog', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    $slug = $request->headers->get('x-slug-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);
    // Log::info('Request Referer: ' . $slug);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    // $artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get();
    $artikel = Post::with('categories')->where('idprofil', $dinas->id)->orderBy('published','desc')->paginate(4);
    $artikela=$artikel->toArray();
    $pageartikel=$referer.'/page/statis/blog';
    $new_artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get()->take(5);
    $category = Category::where('idprofil', $dinas->id)->orderBy('name','asc')->get();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'artikel'=>$artikela, 
        'new_artikel'=>$new_artikel,        
        'category'=>$category,
        'base_url' => $pageartikel, // Tambahkan ini
        'current_page' => $artikel->currentPage(),
        'last_page' => $artikel->lastPage(),
        'next_page_url' => $artikel->nextPageUrl(),
        'prev_page_url' => $artikel->previousPageUrl(),
        ]);
})
->middleware('auth:sanctum');

Route::get('/blogkategori', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    $slug = $request->headers->get('x-slug-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);
    Log::info('Request Referer: ' . $slug);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $categoryfirst = Category::where('name', $slug)->firstOrFail();
    // $artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get();
    // Ambil artikel berdasarkan kategori
    $artikel = Post::with('categories')
    ->whereHas('categories', function ($query) use ($categoryfirst) {
        $query->where('categories.id', $categoryfirst->id);
    })
    ->where('idprofil', $dinas->id) // Pastikan $dinas terdefinisi
    ->orderBy('published', 'desc')
    ->paginate(4);
    $artikela=$artikel->toArray();
    $pageartikel=$referer.'/page/statis/blog';
    $new_artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get()->take(5);
    $category = Category::where('idprofil', $dinas->id)->orderBy('name','asc')->get();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'artikel'=>$artikela, 
        'new_artikel'=>$new_artikel,        
        'category'=>$category,
        'base_url' => $pageartikel, // Tambahkan ini
        'current_page' => $artikel->currentPage(),
        'last_page' => $artikel->lastPage(),
        'next_page_url' => $artikel->nextPageUrl(),
        'prev_page_url' => $artikel->previousPageUrl(),
        ]);
})
->middleware('auth:sanctum');

Route::get('/detailblog', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    $slug = $request->headers->get('x-slug-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);
    // Log::info('Request Referer: ' . $slug);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get()->take(5);
    $category = Category::where('idprofil', $dinas->id)->orderBy('name','asc')->get();
    $detail_blog = Post::with('categories')->where('idprofil', $dinas->id)->where('slug',$slug)->first();
    $category_blog = Category::where('id', $detail_blog->idkategori)->first();

    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'artikel'=>$artikel,        
        'category'=>$category,
        'detail_blog'=>$detail_blog,
        'category_blog'=>$category_blog,
        ]);
})
->middleware('auth:sanctum');

Route::get('/galeri', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $galeri = Galery::where('idprofil', $dinas->id)->orderBy('published','desc')->get();
    $category = Category::where('idprofil', $dinas->id)->orderBy('name','asc')->get();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'galeri'=>$galeri,       
        'category'=>$category,
        ]);
})
->middleware('auth:sanctum');

Route::get('/detailgaleri', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');
    $slug = $request->headers->get('x-slug-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);
    // Log::info('Request Referer: ' . $slug);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $detail_galeri = Galery::where('idprofil', $dinas->id)->where('slug',$slug)->first();
    $image_galeri= $detail_galeri->image_gallery;

    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'detail_galeri'=>$detail_galeri,
        'image_galeri'=>$image_galeri,
        ]);
})
->middleware('auth:sanctum');

Route::get('/pengaduan', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $pengaduan = Complaint::where('idprofil', $dinas->id)->first();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'pengaduan'=>$pengaduan,       
        ]);
})
->middleware('auth:sanctum');

Route::get('/layanan', function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $services = Service::where('idprofil', $dinas->id)->get();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'services'=>$services,       
        ]);
})
->middleware('auth:sanctum');

Route::get('/sarana',action:  function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    $facilities =Facilities::where('idprofil', $dinas->id)->first();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus,
        'facilities'=>$facilities,       
        ]);
})
->middleware('auth:sanctum');

Route::get('/skm',action:  function (Request $request) {
    $domain = $request->getHost();    
    $referer = $request->headers->get('x-custom-header');

    // Cari Dinas berdasarkan domain
    $dinas = Profil::where('domain', $referer)->first();
    // Log::info('Request Domain: ' . $domain);
    // Log::info('Request Referer: ' . $referer);

    // dd($domain);

    if (!$dinas) {
        return response()->json(['message' => 'Dinas not found'], 404);
    }


    // Ambil post berdasarkan dinas_id
    $profil = Profil::where('id', $dinas->id)->first();
    $menu = Adjacency::where('idprofil', $dinas->id)->first();
    // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);

    return response()->json([
        'profil'=>$profil,
        'menus'=>$menus, 
        ]);
});