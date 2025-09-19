<?php

namespace App\Filament\Resources\BackendUserResource\Pages;

use App\Filament\Resources\BackendUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBackendUser extends EditRecord
{
    protected static string $resource = BackendUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
