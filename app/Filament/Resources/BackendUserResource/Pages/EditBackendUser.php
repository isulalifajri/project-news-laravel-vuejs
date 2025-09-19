<?php

namespace App\Filament\Resources\BackendUserResource\Pages;

use App\Filament\Resources\BackendUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Role;

class EditBackendUser extends EditRecord
{
    protected static string $resource = BackendUserResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record) {
            // ambil semua role id yang dimiliki user ini
            $data['roles'] = $this->record->roles->pluck('id')->toArray();
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $roleIds = $this->form->getState()['roles'] ?? [];

        // Ambil model Role sesuai ID
        $roles = Role::whereIn('id', $roleIds)->get();

        // Sync ke user
        $this->record->syncRoles($roles);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->label('Back')
                ->color('primary')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index'))
        ];
    }
}
