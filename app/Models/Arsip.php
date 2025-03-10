<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsips';

    protected $fillable = [
        'kode_qr',
        'kode_arsip',
        'nama_arsip',
        'lokasi',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($arsip) {
            $arsip->kode_arsip = strtoupper(Str::random(9));
    
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCode = $writer->writeString($arsip->kode_arsip);
    
            $fileName = 'qrcodes/' . $arsip->kode_arsip . '.svg';
            \Storage::disk('public')->put($fileName, $qrCode);
            $arsip->kode_qr = $fileName;
        });
    }
    

}
