<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use App\Models\Profil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pengaduan';

    protected static ?string $modelLabel = 'Pengaduan';

    protected static ?string $pluralLabel = 'Pengaduan';

    protected static ?string $navigationGroup = 'Tematik';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sarana Pengaduan')
                // ->description('Put the user name details in.')
                ->schema([
                    Forms\Components\Hidden::make('iduser')
                            ->default(Auth::user()->id),
                    Forms\Components\Select::make('idprofil')
                            ->label('Profil')
                            ->required()
                            ->preload()
                            ->options(function () {
                                return Profil::all()
                                    ->mapWithKeys(function ($profil) {
                                        return [$profil->id => "{$profil->name}"];
                                    }); // NIP sebagai key, "NIP - Nama" sebagai value
                            })
                            ->searchable()
                            ->visible(fn () => Auth::user()->hasRole('super_admin'))
                            ->columnSpanFull(),
                    Forms\Components\Radio::make('kotak')
                        ->options([
                            'Tersedia' => 'Tersedia',
                            'Tidak Tersedia' => 'Tidak Tersedia',
                        ])
                        ->label('Kotak Pengaduan'),
                    Forms\Components\TextInput::make('lapor')
                        ->label('SP4N Lapor')
                        ->default('https://lapor.go.id')
                        ->placeholder('www.lapor.go.id')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fax')
                        ->label('Fax')
                        ->placeholder('022')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telp')
                        ->label('Telepon')
                        ->placeholder('022')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('wa')
                        ->label('Whatsapp')
                        ->placeholder('62801')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->placeholder('admin@mail.com')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fb')
                        ->label('Facebook')
                        ->placeholder('xxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('link_fb')
                        ->label('Link Facebook')
                        ->placeholder('https://xxxxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tw')
                        ->label('Twitter')
                        ->placeholder('xxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('link_tw')
                        ->label('Link Twitter')
                        ->placeholder('https://xxxxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('ig')
                        ->label('Instagram')
                        ->placeholder('xxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('link_ig')
                        ->label('Link Instagram')
                        ->placeholder('https://xxxxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tiktok')
                        ->label('Tiktok')
                        ->placeholder('xxxxxxxx')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('link_tiktok')
                        ->label('Link Tiktok')
                        ->placeholder('https://xxxxxxxxxx')
                        ->maxLength(255),

                ])->columns(2),
                TinyEditor::make('jangka_waktu')
                        ->label('Jangka Waktu Penyelesaian')
                        ->required()
                        ->fileAttachmentsDirectory('jangkawaktuc/'.Auth::user()->idprofil)
                        ->fileAttachmentsVisibility('public'),
                TinyEditor::make('pengelola')
                        ->label('Pengelola/admin')
                        ->required()
                        ->fileAttachmentsDirectory('attachpengelolac/'.Auth::user()->idprofil)
                        ->fileAttachmentsVisibility('public'),
                TinyEditor::make('prosedur')
                        ->label('Prosedur')
                        ->required()
                        ->fileAttachmentsDirectory('attachprosedurc/'.Auth::user()->idprofil)
                        ->fileAttachmentsVisibility('public'),
                Forms\Components\FileUpload::make('image')
                        ->label('Pengelolaan Pengaduan')
                        ->helperText('Unggah gambar terkait Jumlah Pengelolaan pengaduan/Tindak Lanjut. Format yang didukung: JPG, PNG.')
                        ->image()
                        ->directory('pengaduansc/'.Auth::user()->idprofil)
                        ->multiple()
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                // Forms\Components\TextInput::make('image')
                //         ->label('image')
                //         ->placeholder('image')
                //         ->maxLength(255),
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
