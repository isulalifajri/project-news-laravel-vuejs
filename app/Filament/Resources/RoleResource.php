<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // Ambil semua permission dengan guard backend, group berdasarkan field 'groups'
        $groups = Permission::where('guard_name', 'backend')
            ->get()
            ->groupBy(fn ($p) => $p->groups ?? 'other');

        $permissionFields = [];

        foreach ($groups as $groupName => $perms) {
            $slug = \Illuminate\Support\Str::slug($groupName, '_');

            $permissionFields[] = Forms\Components\Fieldset::make(ucfirst($groupName))
                ->schema([
                    Forms\Components\CheckboxList::make('permissions_' . $slug)
                        ->options($perms->pluck('name', 'id')->toArray())
                        ->columns(2)
                        ->afterStateHydrated(function ($component, $state, $record) use ($perms) {
                            if ($record) {
                                // Set state checkbox sesuai permission yang sudah dimiliki role ini
                                $component->state(
                                    $record->permissions()
                                        ->whereIn('id', $perms->pluck('id'))
                                        ->pluck('id')
                                        ->toArray()
                                );
                            }
                        }),
                ]);
        }

        return $form->schema(array_merge([
            Forms\Components\TextInput::make('name')
                ->label('Role Name')
                ->required()
                ->maxLength(255),
        ], $permissionFields));
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\BadgeColumn::make('permissions.name')
                ->label('Permissions')
                ->separator(', '),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
