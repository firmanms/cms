<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleryResource\Pages;
use App\Filament\Resources\GaleryResource\RelationManagers;
use App\Models\Galery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GaleryResource extends Resource
{
    protected static ?string $model = Galery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Galeri';

    protected static ?string $pluralLabel = 'Galeri';

    protected static ?string $navigationGroup = 'Publikasi';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Galeri')
                ->schema([
                        Forms\Components\Hidden::make('iduser')
                            ->default(Auth::user()->id),
                        Forms\Components\Hidden::make('idprofil')
                            ->default(Auth::user()->id),
                            Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Judul')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state, $get) {
                                $idprofil = $get('idprofil');
                                $tanggal = now()->format('dmy');
                                $slug = Str::slug($state);
                                $set('slug', "{$tanggal}-{$idprofil}-{$slug}");
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->readOnly()
                            ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->autosize()
                    ->required(),
                ]),
                Forms\Components\Section::make('Gambar')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                            ->label('Gambar Cover')
                            ->image()
                            ->directory('galeri/'.Auth::user()->idprofil)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                            }),
                    Forms\Components\FileUpload::make('image_gallery')
                            ->label('Gambar Galeri (Maks 5 Foto)')
                            ->image()
                            ->directory('image_galeri/'.Auth::user()->idprofil)
                            ->multiple()
                            ->maxFiles(5)
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                            }),
                ])->columns(2),
                Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\DatePicker::make('published')
                        ->label('Publikasi')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                    Forms\Components\Select::make('category')
                    ->label('Kategori')
                            ->options([
                                'Kegiatan' => 'Kegiatan',
                                'Inovasi' => 'Inovasi',
                                'Prestasi' => 'Prestasi',
                            ])
                    ->searchable()
                    ->preload()
                    ->required(),
                    Forms\Components\Toggle::make('status')
                        ->required(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profil.slug')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                    Tables\Columns\IconColumn::make('status')
                    ->boolean(),Tables\Columns\ToggleColumn::make('status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListGaleries::route('/'),
            'create' => Pages\CreateGalery::route('/create'),
            'edit' => Pages\EditGalery::route('/{record}/edit'),
        ];
    }
}
