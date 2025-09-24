<?php

namespace App\Filament\Resources\CompanyProfileResource\Pages;

use App\Filament\Resources\CompanyProfileResource;
use App\Models\CompanyProfile;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyProfiles extends ListRecords
{
    protected static string $resource = CompanyProfileResource::class;

    protected function getHeaderActions(): array
    {
        if (CompanyProfile::count() > 0) {
            return [];
        }
        return [
            Actions\CreateAction::make(),
        ];
    }
}
