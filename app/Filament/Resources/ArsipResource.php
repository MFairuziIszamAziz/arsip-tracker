<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipResource\Pages;
use App\Filament\Resources\ArsipResource\RelationManagers;
use App\Models\Arsip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class ArsipResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_arsip')
                ->label('Kode Arsip')
                ->required(),
                TextInput::make('nama_arsip')
                ->label('Nama Arsip')
                ->required(),
                TextInput::make('lokasi')
                ->label('Lokasi')
                ->required(),
                TextInput::make('deskripsi')
                ->label('Deskripsi')
                ->nullable(),
            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('kode_arsip')->label('Kode Arsip'),
            TextColumn::make('nama_arsip')->label('Nama Arsip'),
            TextColumn::make('lokasi')->label('Lokasi'),
            ImageColumn::make('qr_code')
    ->label('QR Code')
    ->getStateUsing(function ($record) {
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd() // Gunakan SVG backend, gak butuh GD atau Imagick
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($record->kode_qr);

        return 'data:image/svg+xml;base64,' . base64_encode($qrCode);
    })
])
->actions([
    Tables\Actions\ViewAction::make(), // Tambahkan ini
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
            'index' => Pages\ListArsips::route('/'),
            'create' => Pages\CreateArsip::route('/create'),
            'edit' => Pages\EditArsip::route('/{record}/edit'),
            'view' => Pages\ViewArsip::route('/{record}'),
        ];
    }
}
