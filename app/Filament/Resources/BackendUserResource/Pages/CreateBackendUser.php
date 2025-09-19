<?php

namespace App\Filament\Resources\BackendUserResource\Pages;

use App\Filament\Resources\BackendUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateBackendUser extends CreateRecord
{
    protected static string $resource = BackendUserResource::class;

    protected function afterCreate(): void
    {
        $roleIds = $this->form->getState()['roles'] ?? [];
        $roles = Role::whereIn('id', $roleIds)->get();

        $this->record->syncRoles($roles);
    }
}
