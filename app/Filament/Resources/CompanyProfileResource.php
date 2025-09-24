<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Filament\Resources\CompanyProfileResource\RelationManagers;
use App\Models\CompanyProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Company Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Perusahaan')
                    ->required(),

                Forms\Components\Textarea::make('about')
                    ->label('Tentang Perusahaan')
                    ->rows(4),

                Forms\Components\FileUpload::make('logo')
                    ->label('Logo Perusahaan')
                    ->image()
                    ->directory('company-logo')
                    ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                    ->disk('public')
                    ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('about')->limit(50),
                Tables\Columns\ImageColumn::make('logo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCompanyProfiles::route('/'),
            'create' => Pages\CreateCompanyProfile::route('/create'),
            'edit' => Pages\EditCompanyProfile::route('/{record}/edit'),
        ];
    }
}
