<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Page;
use App\Models\Post;
use App\Models\Profil;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [
            Stat::make('Total Posts', function () {
                $user = Auth::user();
                return Auth::user()->hasRole('super_admin') 
                    ? Post::count() // Total all posts for super_admin
                    : Post::where('iduser', $user->id)->count(); // Posts specific to user
            }),

            Stat::make('Total Halaman', function () {
                $user = Auth::user();
                return Auth::user()->hasRole('super_admin') 
                    ? Page::count() // Total all pages for super_admin
                    : Page::where('iduser', $user->id)->count(); // Pages specific to user
            }),

            Stat::make('Data Pegawai', function () {
                $user = Auth::user();
                return Auth::user()->hasRole('super_admin') 
                    ? Employee::count() // Total all employees for super_admin
                    : Employee::where('iduser', $user->id)->count(); // Employees specific to user
            }),
        ];

        // Add the 'SKPD Pengguna CMS' stat only if the user is a super_admin
        if (Auth::user()->hasRole('super_admin')) {
            $stats[] = Stat::make('SKPD Pengguna CMS', function () {
                return Profil::count(); // Total all SKPD for super_admin
            });
        }

        return $stats;
    }
}
