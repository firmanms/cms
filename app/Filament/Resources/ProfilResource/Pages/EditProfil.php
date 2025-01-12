<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use App\Filament\Resources\ProfilResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditProfil extends EditRecord
{
    protected static string $resource = ProfilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeFill()
    {
        $isSuperAdmin = Auth::user()->hasRole('super_admin'); // Gunakan helper jika tersedia
        $userProfileId = Auth::user()->idprofil;

        // Izinkan akses penuh untuk superadmin
        if ($isSuperAdmin) {
            return;
        }

        // Periksa apakah pengguna dapat mengakses data
        if ($this->record->id == $userProfileId) {
            // \log::warning('Unauthorized access attempt', [
            //     'user_id' => Auth::id(),
            //     'agenda_id' => $this->record->id,
            // ]);
            return;
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
}
