<?php

namespace App\Filament\Resources\FooterContactResource\Pages;

use App\Filament\Resources\FooterContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFooterContact extends EditRecord
{
    protected static string $resource = FooterContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->color('primary')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index'))
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
