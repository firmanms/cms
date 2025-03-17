<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileuploadResource\Pages;
use App\Filament\Resources\FileuploadResource\RelationManagers;
use App\Models\Fileupload;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FileuploadResource extends Resource
{
    protected static ?string $model = Fileupload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Dokumen Upload';

    protected static ?string $modelLabel = 'Dokumen Upload';

    protected static ?string $pluralLabel = 'Dokumen Upload';

    protected static ?string $navigationGroup = 'Publikasi';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Upload File')
                ->description('Materi Rapat, Formulir dan Lainnya')
                ->schema([
                    Forms\Components\Hidden::make('iduser')
                                ->default(Auth::user()->id),
                    Forms\Components\Hidden::make('idprofil')
                                ->default(Auth::user()->idprofil),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                                'Formulir' => 'Formulir',
                                'Materi' => 'Materi',
                                'Produk Hukum' => 'Produk Hukum',
                                'Pengumuman' => 'Pengumuman',
                                'Lainnya' => 'Lainnya',
                        ]),
                        Forms\Components\Select::make('option')
                        ->options([
                            'Upload' => 'Upload',
                            'Url' => 'Link Url',
                        ])                        
                        ->reactive()
                        ->dehydrated(false)
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Set state untuk menentukan tampilan elemen
                            $set('selectedOption', $state);
                    
                            // Inisialisasi ulang dynamicOptions jika URL dipilih
                            if ($state === 'Url') {
                                $set('dynamicOptions', []); // Bisa digunakan nanti untuk keperluan lain
                            }
                        })
                        ->required(),
                    
                    Forms\Components\TextInput::make('url')
                        ->label('Link Url')
                        ->visible(fn ($get) => $get('selectedOption') === 'Url')
                        ->required(fn ($get) => $get('selectedOption') === 'Url') // Wajib jika memilih "Url"
                        ->url(), // Memastikan input berupa URL yang valid
                    
                    Forms\Components\FileUpload::make('url')
                        ->label('File PDF dan semua format Microsoft Office (Word, Excel, PowerPoint)')
                        ->acceptedFileTypes([
                            'application/pdf', // PDF
                            'application/msword', // Word (DOC)
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Word (DOCX)
                            'application/vnd.ms-excel', // Excel (XLS)
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Excel (XLSX)
                            'application/vnd.ms-powerpoint', // PowerPoint (PPT)
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation', // PowerPoint (PPTX)
                        ])
                        ->directory('fileuploads/' . Auth::user()->idprofil)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return now()->timestamp . '-' . preg_replace('/[^A-Za-z0-9.\-_]/', '', $file->getClientOriginalName());
                        })
                        ->visible(fn (callable $get) => $get('selectedOption') === 'Upload')
                        ->required(fn (callable $get) => $get('selectedOption') === 'Upload'),
                    
                    
                ])
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
            'index' => Pages\ListFileuploads::route('/'),
            'create' => Pages\CreateFileupload::route('/create'),
            'edit' => Pages\EditFileupload::route('/{record}/edit'),
        ];
    }
}
