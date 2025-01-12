<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileuploadResource\Pages;
use App\Filament\Resources\FileuploadResource\RelationManagers;
use App\Models\Fileupload;
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
                                ->default(Auth::user()->id),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('url')
                        ->required()
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
                            return now()->timestamp . '-' . $file->getClientOriginalName();
                    }),
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
