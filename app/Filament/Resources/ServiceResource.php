<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Layanan';

    protected static ?string $modelLabel = 'Layanan';

    protected static ?string $pluralLabel = 'Layanan';

    protected static ?string $navigationGroup = 'Tematik';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Layanan di SKPD anda')
                    ->schema([
                        Forms\Components\Hidden::make('iduser')
                            ->default(Auth::user()->id),
                        Forms\Components\Hidden::make('idprofil')
                            ->default(Auth::user()->idprofil),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama Layanan')
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
                        TinyEditor::make('requirement')
                            ->label('Persyaratan')
                            ->required()
                            ->fileAttachmentsDirectory('attachrequirement/'.Auth::user()->idprofil)
                            ->fileAttachmentsVisibility('public'),
                        TinyEditor::make('procedure')
                            ->label('Prosedur')
                            ->required()
                            ->fileAttachmentsDirectory('attachprocedure/'.Auth::user()->idprofil)
                            ->fileAttachmentsVisibility('public'),
                        Forms\Components\TextInput::make('time')
                            ->label('Waktu Penyelesaian')
                            ->required()
                            ->maxLength(255),
                        TinyEditor::make('cost')
                            ->label('Biaya')
                            ->required()
                            ->fileAttachmentsDirectory('attachcost/'.Auth::user()->idprofil)
                            ->fileAttachmentsVisibility('public'),
                        TinyEditor::make('product')
                            ->label('Produk Pelayanan')
                            ->required()
                            ->fileAttachmentsDirectory('attachproduct/'.Auth::user()->idprofil)
                            ->fileAttachmentsVisibility('public'),
                        TinyEditor::make('complaint')
                            ->label('Pengaduan')
                            ->required()
                            ->fileAttachmentsDirectory('attachcomplaintss/'.Auth::user()->idprofil)
                            ->fileAttachmentsVisibility('public'),
                        Forms\Components\Toggle::make('status')
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profil.slug')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->onColor('success')
                    ->offColor('danger')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
