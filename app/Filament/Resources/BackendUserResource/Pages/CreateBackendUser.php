<?php

namespace App\Filament\Resources\BackendUserResource\Pages;

use App\Filament\Resources\BackendUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBackendUser extends CreateRecord
{
    protected static string $resource = BackendUserResource::class;
}
