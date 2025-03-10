<?php
use Filament\Panel;
use Filament\PanelProvider;

class FilamentServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->brandName('Arsip')
            ->viteTheme('resources/css/custom.css'); // Tambah CSS
    }
}
