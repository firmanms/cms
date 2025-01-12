<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Page;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', function () {
                $user = Auth::user();
            
                // Jika super_admin, hitung semua post
                if (Auth::user()->hasRole('super_admin')) {
                    return Post::count(); // Total semua post
                }
            
                // Jika user biasa, hitung post berdasarkan iduser
                return Post::where('iduser', $user->id)->count(); // Total post milik user tertentu
            }),
            Stat::make('Total Halaman', function () {
                $user = Auth::user();
            
                // Jika super_admin, hitung semua halaman
                if (Auth::user()->hasRole('super_admin')) {
                    return Page::count(); // Total semua halaman
                }
            
                // Jika user biasa, hitung halaman berdasarkan iduser
                return Page::where('iduser', $user->id)->count(); // Total halaman milik user tertentu
            }),
            Stat::make('Data Pegawai', function () {
                $user = Auth::user();
            
                // Jika super_admin, hitung semua pegawai
                if (Auth::user()->hasRole('super_admin')) {
                    return Employee::count(); // Total semua pegawai
                }
            
                // Jika user biasa, hitung pegawai berdasarkan iduser
                return Employee::where('iduser', $user->id)->count(); // Total pegawai milik user tertentu
            }),
        ];
    }
}
