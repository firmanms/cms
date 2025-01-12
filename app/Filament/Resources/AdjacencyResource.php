<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdjacencyResource\Pages;
use App\Filament\Resources\AdjacencyResource\RelationManagers;
use App\Models\Adjacency;
use App\Models\Api;
use App\Models\Page;
use App\Models\Profil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class AdjacencyResource extends Resource
{
    protected static ?string $model = Adjacency::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Menu';

    protected static ?string $modelLabel = 'Menu';

    protected static ?string $pluralLabel = 'Menu';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pengaturan Menu')
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
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        AdjacencyList::make('subject')
                        ->maxDepth(1)
                        ->form([
                            Forms\Components\TextInput::make('label')
                                ->required(),
                                Forms\Components\Select::make('option')
                                    ->label('Link')
                                    ->options([
                                        'linkinternal' => 'URL Internal',
                                        'internal' => 'Halaman',
                                        'external' => 'External',
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('selectedOption', $state);
                                    
                                        if ($state === 'internal') {
                                            // Ambil profil ID melalui relasi
                                            $profilId = Auth::user()->idprofil;
                                        
                                            if ($profilId) {
                                                // Ambil data dari database untuk select pertama (kondisi internal)
                                                $data = Page::where('idprofil', $profilId)->pluck('title', 'slug')->toArray();
                                                $set('dynamicOptions', $data);
                                            } else {
                                                // Jika profil tidak ditemukan
                                                $set('dynamicOptions', []);
                                            }
                                        } elseif ($state === 'linkinternal') {
                                            // Ambil profil ID melalui relasi
                                            $profilId = Auth::user()->idprofil;
                                        
                                            if ($profilId) {
                                                // Ambil data dari database untuk select kedua (kondisi linkinternal)
                                                $data = Api::where('idprofil', $profilId)->pluck('name', 'url')->toArray();
                                                $set('dynamicOptions', $data);
                                            } else {
                                                // Jika profil tidak ditemukan
                                                $set('dynamicOptions', []);
                                            }
                                        }
                                    })
                                    ->required(),
                                    Forms\Components\Group::make([
                                        Forms\Components\Select::make('link')
                                            ->label('Pilih Halaman')
                                            ->options(fn ($get) => $get('dynamicOptions') ?? [])
                                            ->visible(fn ($get) => $get('selectedOption') === 'internal'),

                                            Forms\Components\Select::make('link')
                                            ->label('Pilih URL')
                                            ->options(fn ($get) => $get('dynamicOptions') ?? [])
                                            ->visible(fn ($get) => $get('selectedOption') === 'linkinternal'),



                                            Forms\Components\TextInput::make('link')
                                            ->label('Input Teks')
                                            ->visible(fn ($get) => $get('selectedOption') === 'external')
                                            ->required(),
                                    ]),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iduser')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('idprofil')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListAdjacencies::route('/'),
            'create' => Pages\CreateAdjacency::route('/create'),
            'edit' => Pages\EditAdjacency::route('/{record}/edit'),
        ];
    }
}
