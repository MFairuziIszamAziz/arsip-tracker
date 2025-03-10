<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use App\Filament\Resources\ArsipResource\Pages\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\ViewField;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class ViewArsip extends ViewRecord
{
    protected static string $resource = ArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
{
    return $form
        ->schema([
            \Filament\Forms\Components\Grid::make(2) // Ganti 1 menjadi 2 kolom
                ->schema([
                    Section::make('QR Code')
    ->schema([
        ViewField::make('qr_code')
            ->label('QR CODE')
            ->view('components.qr-code')
            ->state(fn ($record) => $record && $record->kode_qr
                ? self::generateQrCode($record->kode_qr)
                : null
            )
            ->columnSpanFull(),
    ])
    ->columnSpan(1),
Section::make('QR Code')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('qr_code')
                            ->label('QR CODE')
                            ->content(fn ($record) => dd($record)) // Debug isi $record                        
                                ->view('components.qr-code')
                                ->state(fn ($record) => self::generateQrCode($record->kode_qr))
                                ->columnSpanFull(), // Agar QR Code tampil penuh dalam section-nya
                        ])
                        ->columnSpan(1), // QR Code di satu kolom

                    Section::make('Detail Arsip')
                        ->schema([
                            Placeholder::make('kode_qr')->label('Kode QR')->content(fn ($record) => $record->kode_qr),
                            Placeholder::make('kode_arsip')->label('Kode Arsip')->content(fn ($record) => $record->kode_arsip),
                            Placeholder::make('nama_arsip')->label('Nama Arsip')->content(fn ($record) => $record->nama_arsip),
                            Placeholder::make('lokasi')->label('Lokasi')->content(fn ($record) => $record->lokasi),
                            Placeholder::make('deskripsi')->label('Deskripsi')->content(fn ($record) => $record->deskripsi),
                        ])
                        ->columnSpan(1), // Detail Arsip di kolom lain
                ]),
        ]);
}




    private static function generateQrCode($kode)
    {
        if (!$kode) return null;

        $renderer = new ImageRenderer(
            new RendererStyle(250),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($kode);

        dd($qrCode);

        return 'data:image/svg+xml;base64,' . base64_encode($qrCode);
    }
}

