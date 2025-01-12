<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilitiesResource\Pages;
use App\Filament\Resources\FacilitiesResource\RelationManagers;
use App\Models\Facilities;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FacilitiesResource extends Resource
{
    protected static ?string $model = Facilities::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Fasilitas';

    protected static ?string $modelLabel = 'Fasilitas';

    protected static ?string $pluralLabel = 'Fasilitas';

    protected static ?string $navigationGroup = 'Tematik';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Maklumat, Visi Misi dan lainnya')
                ->description('Maksimal upload 3 gambar')
                ->schema([
                    Forms\Components\Hidden::make('iduser')
                            ->default(Auth::user()->id),
                    Forms\Components\Hidden::make('idprofil')
                            ->default(Auth::user()->id),
                    Forms\Components\FileUpload::make('maklumat')
                        ->label('Maklumat')
                        ->image()
                        ->directory('maklumat/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('visi')
                        ->label('Visi')
                        ->image()
                        ->directory('visi/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('misi')
                        ->label('Misi')
                        ->image()
                        ->directory('misi/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('motto')
                        ->label('Motto')
                        ->image()
                        ->directory('motto/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('kode_etik')
                        ->label('Kode Etik')
                        ->image()
                        ->directory('kode_etik/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('tata_tertib')
                        ->label('Tata Tertib')
                        ->image()
                        ->directory('tata_tertib/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('si_pelayanan_publik')
                        ->label('Sistem Informasi Pelayanan Publik')
                        ->image()
                        ->directory('si_pelayanan_publik/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                ])->columns(4),
                Forms\Components\Section::make('Sarana')
                ->description('Maksimal upload 3 gambar')
                ->schema([
                    Forms\Components\FileUpload::make('ruang_tunggu')
                        ->label('Ruang Tunggu')
                        ->image()
                        ->directory('ruang_tunggu/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('meja_layanan')
                        ->label('Meja Layanan')
                        ->image()
                        ->directory('meja_layanan/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('parkir')
                        ->label('Parkir')
                        ->image()
                        ->directory('parkir/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('tempat_ibadah')
                        ->label('Tempat Ibadah')
                        ->image()
                        ->directory('tempat_ibadah/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('charger')
                        ->label('Charger')
                        ->image()
                        ->directory('charger/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('pojok_baca')
                        ->label('Pojok Baca')
                        ->image()
                        ->directory('pojok_baca/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('toilet')
                        ->label('Toilet')
                        ->image()
                        ->directory('toilet/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),

                ])->columns(3),
                Forms\Components\Section::make('Sarana Khusus')
                ->description('Maksimal upload 3 gambar')
                ->schema([
                    Forms\Components\FileUpload::make('petunjuk_layanan_khusus')
                        ->label('Petunjuk Layanan/Papan Informasi Khusus')
                        ->image()
                        ->directory('petunjuk_layanan_khusus/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('petunjuk_tanda')
                        ->label('Petunjuk Seperti Tanda Lansia dan Ibu Menyusui')
                        ->image()
                        ->directory('petunjuk_tanda/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('narator')
                        ->label('Narator/Audio')
                        ->image()
                        ->directory('narator/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('huruf_braile')
                        ->label('Papan Informasi Huruf Braile')
                        ->image()
                        ->directory('huruf_braile/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('kursi_roda')
                        ->label('Kursi Roda')
                        ->image()
                        ->directory('kursi_roda/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('rambatan')
                        ->label('Ram Rambatan')
                        ->image()
                        ->directory('rambatan/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('laktasi')
                        ->label('Laktasi')
                        ->image()
                        ->directory('laktasi/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('toilet_disabilitas')
                        ->label('Toilet Disabilitas')
                        ->image()
                        ->directory('toilet_disabilitas/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('kursi_prioritas')
                        ->label('Kursi Prioritas')
                        ->image()
                        ->directory('kursi_prioritas/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('parkir_khusus')
                        ->label('Parkir Khusus')
                        ->image()
                        ->directory('parkir_khusus/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('tempat_main')
                        ->label('Tempat Bermain Anak')
                        ->image()
                        ->directory('tempat_main/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('lantai_pemandu')
                        ->label('Lantai Pemandu/ Guiding Block')
                        ->image()
                        ->directory('lantai_pemandu/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),

                ])->columns(4),
                Forms\Components\Section::make('Sarana Keamanan')
                ->description('Maksimal upload 3 gambar')
                ->schema([
                    Forms\Components\FileUpload::make('apar')
                        ->label('Apar')
                        ->image()
                        ->directory('apar/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('jalur_evakuasi')
                        ->label('Jalur Evakuasi')
                        ->image()
                        ->directory('jalur_evakuasi/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('cctv')
                        ->label('cctv')
                        ->image()
                        ->directory('cctv/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('petugas_keamanan')
                        ->label('Petugas Keamanan')
                        ->image()
                        ->directory('petugas_keamanan/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('titik_kumpul')
                        ->label('Titik Kumpul')
                        ->image()
                        ->directory('titik_kumpul/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('ruang_arsip')
                        ->label('Ruang Arsip')
                        ->image()
                        ->directory('ruang_arsip/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    Forms\Components\FileUpload::make('red_button')
                        ->label('Red Button/Tombol Darurat')
                        ->image()
                        ->directory('red_button/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                ])->columns(4),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profil.slug')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir diubah')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $profilId = Auth::user()->idprofil;
                // dd($profilId);
                

                $roles = Auth::user()->roles->pluck('name'); // Atau metode lain jika berbeda

                $roleNames = $roles->implode(', ');
                // dd($roleNames);
                // Cek apakah pengguna memiliki salah satu dari peran yang diizinkan
                if ($roles->contains('super_admin')) {
                    // Jika pengguna memiliki peran 'super_admin', kembalikan semua data
                    return $query;
                } else {
                    // Jika pengguna tidak memiliki peran yang sesuai
                    return $query->where('idprofil', $profilId); // Contoh kondisi tambahan
                }
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacilities::route('/create'),
            'edit' => Pages\EditFacilities::route('/{record}/edit'),
        ];
    }
}
