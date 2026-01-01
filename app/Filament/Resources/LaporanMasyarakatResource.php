<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanMasyarakatResource\Pages;
use App\Models\LaporanMasyarakat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LaporanMasyarakatResource extends Resource
{
    protected static ?string $model = LaporanMasyarakat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // 📍 Tab Informasi Utama
                        Forms\Components\Tabs\Tab::make('Informasi Utama')
                            ->schema([
                                Forms\Components\FileUpload::make('foto')
                                    ->label('Lampiran')
                                    ->image()
                                    ->directory('laporan')
                                    ->visibility('public')
                                    ->required()
                                    ->disabled(),

                                Forms\Components\TextInput::make('lokasi_kejadian')
                                    ->label('Lokasi Kejadian')
                                    ->required()
                                    ->disabled(),

                                Forms\Components\Textarea::make('deskripsi_kejadian')
                                    ->label('Deskripsi Kejadian')
                                    ->required()
                                    ->disabled(),

                                Forms\Components\Select::make('kecamatan_id')
                                    ->label('Kecamatan')
                                    ->relationship('kecamatan', 'nama')
                                    ->required()
                                    ->disabled(),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'menunggu' => 'Menunggu',
                                        'diproses' => 'Diproses',
                                        'selesai'  => 'Selesai',
                                    ])
                                    ->default('menunggu')
                                    ->required(),
                            ]),


                    ])->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Lampiran')
                    ->disk('public')
                    ->height(60)
                    ->width(100),

                Tables\Columns\TextColumn::make('lokasi_kejadian')
                    ->label('Lokasi'),

                Tables\Columns\TextColumn::make('deskripsi_kejadian')
                    ->label('Deskripsi'),


                Tables\Columns\TextColumn::make('kecamatan.nama')
                    ->label('Kecamatan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'menunggu',
                        'info'    => 'diproses',
                        'success' => 'selesai',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                // Kalau mau ditambah Tabs filter di table bisa juga
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLaporanMasyarakats::route('/'),
            'create' => Pages\CreateLaporanMasyarakat::route('/create'),
            'edit' => Pages\EditLaporanMasyarakat::route('/{record}/edit'),
        ];
    }
}