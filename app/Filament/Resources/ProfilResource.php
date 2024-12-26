<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilResource\Pages;
use App\Filament\Resources\ProfilResource\RelationManagers;
use App\Models\Profil;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProfilResource extends Resource
{
    protected static ?string $model = Profil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Website')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->placeholder('Dinas Pertanian')
                        // ->readOnly()
                        ->maxLength(255),
                     TextInput::make('singkatan')
                        ->label('Singkatan')
                        ->required()
                        ->placeholder( 'Distan')
                        // ->readOnly()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', Str::slug($state));
                        }),
                    Hidden::make('slug')
                        ->required(),
                        // ->readOnly()
                        // ->maxLength(255),
                    FileUpload::make('logo')
                        ->required()
                        ->label('Logo')
                        ->image()
                        ->directory('logo/'. Auth::user()->idprofil)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                    FileUpload::make('favicon')
                        ->required()
                        ->label('Favicon')
                        ->image()
                        ->directory('favicon/'. Auth::user()->idprofil)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                        }),
                ])->columns(2),

                Section::make('Informasi Kantor')
                    ->schema([
                        TextInput::make('office_name')
                            ->required()
                            ->label('Nama Kantor')
                            ->placeholder('Dinas Pertanian')
                            ->maxLength(255),
                        Textarea::make('office_address')
                            ->required()
                            ->label('Alamat Kantor')
                            ->maxLength(255),
                        Textarea::make('url_maps')
                            ->required()
                            ->label('URL Google Maps')
                            ->placeholder('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d'),
                        TextInput::make('leader_name')
                            ->required()
                            ->label('Nama Pimpinan')
                            ->maxLength(255),
                        FileUpload::make('leader_foto')
                            ->required()
                            ->label('Foto Pimpinan')
                            ->image() // Restrict to image uploads (JPG, PNG, etc.)
                            ->directory('leader_foto/' . Auth::user()->idprofil) // Store in a user-specific directory
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str($file->getClientOriginalName())->prepend(now()->timestamp);
                            }),
                        Textarea::make('video_profile')
                            ->required()
                            ->label('URL Video Youtube')
                            ->maxLength(255)
                            ->placeholder('https://www.youtube.com/watch?v=y7j5u7fwBK8'),
                        TextInput::make('office_telp')
                            ->required()
                            ->label('Telp Kantor')
                            ->placeholder('6222')
                            ->maxLength(255),
                        TextInput::make('office_whatsapp')
                            ->required()
                            ->label('Whatsapp Kantor')
                            ->placeholder('62851')
                            ->maxLength(255),
                        TextInput::make('office_email')
                            ->required()
                            ->email()
                            ->label('Email Kantor')
                            ->maxLength(255),
                        Textarea::make('open_hour')
                            ->required()
                            ->label('Jam Operasional')
                            ->maxLength(255),
                        TextInput::make('nickname')
                            ->label('Sebutan Pimpinan')
                            ->required()
                            ->placeholder('Kepala Dinas')
                            ->maxLength(255),
                        RichEditor::make('maintask')
                            ->required()
                            ->label('Footer')
                            ->toolbarButtons([

                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                        RichEditor::make('overview')
                            ->required()
                            ->label('Selayang Pandang')
                            ->toolbarButtons([

                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                        RichEditor::make('welcome')
                            ->required()
                            ->label('Sambutan Pimpinan')
                            ->toolbarButtons([

                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                    ])->columns(2),

                    Section::make('Media Sosial Kantor')
                    ->description('Masukkan username/channel id saja')
                    ->schema([
                        TextInput::make('fb')
                            ->label('Facebook')
                            ->placeholder('https://facebook.com/username')
                            ->maxLength(255),
                        TextInput::make('ig')
                            ->placeholder('https://instagram.com/username')
                            ->label('Instagram')
                            ->maxLength(255),
                        TextInput::make('tw')
                            ->placeholder('https://twitter.com/username')
                            ->label('Twitter')
                            ->maxLength(255),
                        TextInput::make('channel_yt')
                            ->placeholder('https://youtube.com/username')
                            ->label('Channel Youtube')
                            ->maxLength(255),
                        TextInput::make('tiktok')
                            ->placeholder('https://tiktok.com/username')
                            ->label('Tiktok')
                            ->maxLength(255),
                    ])->columns(3),

                    Section::make('Informasi SEO')
                    ->description('Untuk pencarian google')
                    ->schema([
                        TextInput::make('seo_desc')
                            ->label('SEO description')
                            ->placeholder('Website Dinas Pertanian')
                            ->required()
                            ->maxLength(255),
                        TagsInput::make('seo_keywords')
                            ->label('SEO Keywords')
                            ->required()
                            ->placeholder('Tambah SEO keywords')
                            ->splitKeys(['Enter', ',', ';']) // Split by Enter, comma, or semicolon
                            ->suggestions(['Dinas Pertanian', 'Web', 'Kabupaten Bandung']), // Optional suggestions
                    ])->columns(2),
                
                Forms\Components\Toggle::make('status')
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
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
            ]);
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
            'index' => Pages\ListProfils::route('/'),
            'create' => Pages\CreateProfil::route('/create'),
            'edit' => Pages\EditProfil::route('/{record}/edit'),
        ];
    }
}