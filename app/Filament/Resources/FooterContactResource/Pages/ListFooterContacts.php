<?php

namespace App\Filament\Resources\FooterContactResource\Pages;

use App\Filament\Resources\FooterContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\FooterContact;

class ListFooterContacts extends ListRecords
{
    protected static string $resource = FooterContactResource::class;

    protected function getHeaderActions(): array
    {
        if (FooterContact::count() > 0) {
            return [];
        }
        return [
            Actions\CreateAction::make(),
        ];
    }
}
