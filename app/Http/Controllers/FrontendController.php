<?php

namespace App\Http\Controllers;

use App\Models\Adjacency;
use App\Models\Agenda;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Employee;
use App\Models\Facilities;
use App\Models\Faq;
use App\Models\Fileupload;
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
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function beranda(Request $request)
    {
        $profil          = Profil::first();
        $ipAddress = $request->ip(); // Mendapatkan alamat IP pengunjung
        $visitDate = Carbon::now()->toDateString(); // Mendapatkan tanggal saat ini 
        Visitor::firstOrCreate(
            ['ip_address' => $ipAddress, 'visit_date' => $visitDate],
            ['domain' => $profil->domain, 'visit_date' => $visitDate]
        );
        $view = Viewer::firstOrCreate(['page' => $profil->domain],['domain' => $profil->domain]);
        $view->increment('count'); // Menambah jumlah tampilan
        //profil
        
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $slide           = Slide::where('idprofil',$profil->id)->get();
        $posting         = Post::with('categories')->where('idprofil',$profil->id)->where('status',1)->orderBy('published','desc')->get()->take(9);
        $employee        = Employee::where('idprofil',$profil->id)->get();
        // $posts           = Profil::where('id',$profil->id)->get();
        $page            = Page::where('idprofil',$profil->id)->get();
        // $artikel         = Post::where('idprofil',$profil->id)->get();
        $kategori_banner = Banner::distinct()->pluck('kategori');
        $banner          = Banner::where('idprofil',$profil->id)->get();
        // Ambil agenda dengan memastikan tidak termasuk yang dipublikasikan kemarin
        $yesterday = Carbon::yesterday()->startOfDay();
        $today = Carbon::today()->startOfDay();
        $agenda = Agenda::where('idprofil',$profil->id)
                         ->where('published', '>=', value: $today)
                         ->orderBy('published', 'asc')
                         ->get();
        $faq             = Faq::where('idprofil',$profil->id)->get();
        $relatedlink     = Related::where('idprofil',$profil->id)->get();
    
        //visitor
        $today = Carbon::today();
        $dailyVisitors  = Visitor::whereDate('created_at', $today)->where('domain',$profil->domain)->count();
        $allVisitors    = Visitor::where('domain',$profil->domain)->count();
        $viewCount      = Viewer::where('domain',$profil->domain)->first();
    
        // dd($menu);
            $jsonString = $menu['subject'];
            $jsonStrings = json_encode($jsonString);
    
            $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.index',
        compact(
            'profil',
            'menus',
            'slide',
            'posting',
            'employee',
            'kategori_banner',
            'banner',
            'agenda',
            'faq',
            'relatedlink',
            'dailyVisitors',
            'allVisitors',
            'viewCount'));
    }

    public function blog(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $artikel         = Post::with('categories')->where('idprofil', $profil->id)->orderBy('published','desc')->paginate(4);
        $new_artikel     = Post::where('idprofil', $profil->id)->orderBy('published','desc')->get()->take(5);
        $category      = Category::where('idprofil', $profil->id)->orderBy('name','asc')->get();
        // Mendapatkan informasi pagination
        $currentPage = $artikel->currentPage(); // Halaman saat ini
        $lastPage = $artikel->lastPage(); // Total halaman
        // Menentukan base URL
        $baseUrl = $request->url(); // Mengambil URL saat ini
            
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.blog',
        compact(
            'profil',
            'menus',
            'artikel',
            'category',
            'new_artikel',
            'currentPage',
            'lastPage',
            'baseUrl'));
        
    }

    public function blogkategori(Request $request,string $slug)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $categoryfirst   = Category::where('name', $slug)->firstOrFail();
        // $artikel = Post::where('idprofil', $dinas->id)->orderBy('published','desc')->get();
        // Ambil artikel berdasarkan kategori
        $artikel = Post::with('categories')
        ->whereHas('categories', function ($query) use ($categoryfirst) {
            $query->where('categories.id', $categoryfirst->id);
        })
        ->where('idprofil', $profil->id) // Pastikan $dinas terdefinisi
        ->orderBy('published', 'desc')
        ->paginate(4);
        $new_artikel     = Post::where('idprofil', $profil->id)->orderBy('published','desc')->get()->take(5);
        $category      = Category::where('idprofil', $profil->id)->orderBy('name','asc')->get();
        // Mendapatkan informasi pagination
        $currentPage = $artikel->currentPage(); // Halaman saat ini
        $lastPage = $artikel->lastPage(); // Total halaman
        // Menentukan base URL
        $baseUrl = $request->url(); // Mengambil URL saat ini
            
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.blog_kategori',
        compact(
            'profil',
            'menus',
            'artikel',
            'category',
            'categoryfirst',
            'new_artikel',
            'currentPage',
            'lastPage',
            'baseUrl'));      

    }

    public function page(Request $request)
    {

    }

    public function singlepage(Request $request,string $slug)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $page            = Page::where('idprofil', $profil->id)->where('slug',$slug)->first();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.page',
        compact(
            'profil',
            'menus',
            'page'));

    }

    public function blogdetail(Request $request,string $slug)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $artikel         = Post::where('idprofil', $profil->id)->orderBy('published','desc')->get()->take(5);
        $category        = Category::where('idprofil', $profil->id)->orderBy('name','asc')->get();
        $detail_blog     = Post::with('categories')->where('idprofil', $profil->id)->where('slug',$slug)->first();
        $category_blog   = Category::where('id', $detail_blog->idkategori)->first();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.blog_detail',
        compact(
            'profil',
            'menus',
            'artikel',
            'category',
            'detail_blog',
            'category_blog'));

    }

    public function galeri(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $galeri          = Galery::where('idprofil', $profil->id)->orderBy('published','desc')->get();
        $category        = Category::where('idprofil', $profil->id)->orderBy('name','asc')->get();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.galeri',
        compact(
            'profil',
            'menus',
            'galeri',
            'category'));

    }

    public function galeridetail(Request $request,string $slug)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $detail_galeri   = Galery::where('idprofil', $profil->id)->where('slug',$slug)->first();
        $image_galeri= $detail_galeri->image_gallery;
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.galeri_detail',
        compact(
            'profil',
            'menus',
            'detail_galeri',
            'image_galeri'));

    }

    public function layanan(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $services        = Service::where('idprofil', $profil->id)->get();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.layanan',
        compact(
            'profil',
            'menus',
            'services'));

    }

    public function produkhukum(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        // Cek apakah ada pencarian
        $search = $request->input('search');
        $fileupload = Fileupload::where('idprofil', $profil->id)
                                ->where('kategori', 'Produk Hukum')
                                ->when($search, function ($query, $search) {
                                    return $query->where('title', 'LIKE', "%{$search}%");
                                })
                                ->paginate(5); // Menampilkan 5 data per halaman
        // Mendapatkan informasi pagination
        $currentPage = $fileupload->currentPage(); // Halaman saat ini
        $lastPage = $fileupload->lastPage(); // Total halaman
        // Menentukan base URL
        $baseUrl = $request->url(); // Mengambil URL saat ini

        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.produkhukum',
        compact(
            'profil',
            'menus',
            'fileupload','currentPage','lastPage','baseUrl'));
    }

    public function dokumenupload(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        // Cek apakah ada pencarian
        $search = $request->input('search');
        $fileupload = Fileupload::where('idprofil', $profil->id)
                                ->whereNot('kategori', 'Produk Hukum')
                                ->when($search, function ($query, $search) {
                                    return $query->where('title', 'LIKE', "%{$search}%");
                                })
                                ->paginate(1); // Menampilkan 5 data per halaman
        // Mendapatkan informasi pagination
        $currentPage = $fileupload->currentPage(); // Halaman saat ini
        $lastPage = $fileupload->lastPage(); // Total halaman
        // Menentukan base URL
        $baseUrl = $request->url(); // Mengambil URL saat ini

        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.dokumenupload',
        compact(
            'profil',
            'menus',
            'fileupload','currentPage','lastPage','baseUrl'));
    }

    public function sarana(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $facilities      = Facilities::where('idprofil', $profil->id)->first();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.sarana',
        compact(
            'profil',
            'menus',
            'facilities'));

    }

    public function pengaduan(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        $pengaduan       = Complaint::where('idprofil', $profil->id)->first();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.pengaduan',
        compact(
            'profil',
            'menus',
            'pengaduan'));


    }

    public function skm(Request $request)
    {
        $profil          = Profil::first();
        $menu            = Adjacency::where('idprofil',$profil->id)->first();
        
        // dd($menu);
        $jsonString = $menu['subject'];
        $jsonStrings = json_encode($jsonString);

        $menus = json_decode($jsonStrings, true);
        return view('theme.flexstart.skm',
        compact(
            'profil',
            'menus',));

    }
    
}
