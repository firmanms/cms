<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;

class TrackVisitors
{
    public function handle($request, Closure $next)
    {
        // Mendapatkan alamat IP pengunjung
        $ipAddress = $request->ip();

        // Mendapatkan nama domain
        $domain = $request->getHost(); // Mengambil nama domain dari request

        // Mencatat pengunjung jika alamat IP belum ada di database
        Visitor::firstOrCreate(['ip_address' => $ipAddress], ['domain' => $domain]);

        return $next($request);
    }
}
