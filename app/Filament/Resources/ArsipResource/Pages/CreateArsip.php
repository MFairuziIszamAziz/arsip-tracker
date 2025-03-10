<?php

namespace App\Filament\Resources\ArsipResource\Pages;

use App\Filament\Resources\ArsipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArsip extends CreateRecord
{
    protected static string $resource = ArsipResource::class;

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ]);

    // $validated['kode_arsip'] = strtoupper(Str::random(10));

    Arsip::create($validated);

    return redirect()->route('arsip.index')->with('success', 'Arsip berhasil ditambahkan.');
}

}
