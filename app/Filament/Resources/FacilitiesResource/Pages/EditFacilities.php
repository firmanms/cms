<?php

namespace App\Filament\Resources\FacilitiesResource\Pages;

use App\Filament\Resources\FacilitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditFacilities extends EditRecord
{
    protected static string $resource = FacilitiesResource::class;

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
        if ($this->record->idprofil == $userProfileId) {
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