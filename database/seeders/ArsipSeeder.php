<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Arsip;

class ArsipSeeder extends Seeder
{
    public function run()
    {
        Arsip::create([
            'kode_barcode' => '123456789',
            'nama_arsip' => 'Surat Keputusan',
            'lokasi' => 'Lantai 2, Rak A, Box 3',
            'deskripsi' => 'Dokumen keputusan.'
        ]);
    }
}

