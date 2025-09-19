<?php

namespace App\Filament\Resources\BackendUserResource\Pages;

use App\Filament\Resources\BackendUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBackendUsers extends ListRecords
{
    protected static string $resource = BackendUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
