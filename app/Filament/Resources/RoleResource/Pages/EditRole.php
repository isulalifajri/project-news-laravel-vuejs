<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // semua permission id yg dimiliki role ini
        $ownedIds = $this->record->permissions()->pluck('id')->toArray();

        // kelompok permission id per group
        $groups = Permission::where('guard_name', 'backend')
            ->get()
            ->groupBy(fn ($p) => $p->groups ?? 'other');

        foreach ($groups as $group => $perms) {
            $slug = Str::slug($group, '_');
            // isi checkbox sesuai irisan antara role_has_permissions dan group ini
            $data['permissions_' . $slug] = array_intersect(
                $ownedIds,
                $perms->pluck('id')->toArray()
            );
        }

        return $data;
    }

    // simpan perubahan
    protected function afterSave(): void
    {
        $ids = collect($this->form->getState())
            ->filter(fn ($v, $k) => str_starts_with($k, 'permissions_'))
            ->flatten()
            ->filter()
            ->toArray();

        $this->record->permissions()->sync($ids);
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
