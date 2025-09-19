<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // hapus semua permissions_* supaya tidak dimasukkan ke tabel roles
        $data = collect($data)
            ->reject(fn($v, $k) => str_starts_with($k, 'permissions_'))
            ->toArray();

        return $data;
    }

    protected function afterCreate(): void
    {
        $ids = collect($this->form->getState())
                ->filter(fn ($v, $k) => str_starts_with($k, 'permissions_'))
                ->flatten()
                ->filter()
                ->toArray();

            $this->record->permissions()->sync($ids);
    }
}
