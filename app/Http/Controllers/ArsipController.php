<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function scan(){
        return view ('scan');
    }
    public function cariArsip($barcode)
    {
        $arsip = Arsip::where('kode_barcode', $barcode)->first();

        if (!$arsip){
            return response ()->json(['message'=>'Arsip tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_arsip' => $arsip->nama_arsip,
            'lokasi' => $arsip->lokasi,
            'deskripsi' => $arsip->deskripsi
        ]);
    }
}
