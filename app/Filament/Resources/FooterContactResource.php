<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterContactResource\Pages;
use App\Filament\Resources\FooterContactResource\RelationManagers;
use App\Models\FooterContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FooterContactResource extends Resource
{
    protected static ?string $model = FooterContact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Company Management';

    public static function form(Form $form): Form
    {
        if ($form->getOperation() === 'edit') {
            return $form->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Label')
                    ->readOnly(),

                Forms\Components\TextInput::make('value')
                    ->label(fn ($record) => $record?->type ?? 'Fill Content')
                    ->required(),

                Forms\Components\TextInput::make('icon')
                    ->label('Icon Sosial')
                    ->visible(fn ($record) => $record?->type === 'social'),

                Forms\Components\TextInput::make('type')
                    ->disabled()
                    ->dehydrated(), // tetap disimpan

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktifkan?'),
            ]);
        }

        // 👉 CREATE
        $hasContacts = FooterContact::whereIn('type', ['address', 'phone', 'email'])->exists();

        $schema = [];

        // Hanya tampilkan field kontak kalau belum ada
        if (! $hasContacts) {
            $schema[] = Forms\Components\TextInput::make('label')
                ->label('Label')
                ->default('GET IN TOUCH')
                ->readOnly();

            $schema[] = Forms\Components\TextInput::make('address')
                ->label('Alamat')
                ->placeholder('123 Street, New York, USA')
                ->required();

            $schema[] = Forms\Components\TextInput::make('phone')
                ->label('Nomor Telepon')
                ->placeholder('+012 345 67890')
                ->required();

            $schema[] = Forms\Components\TextInput::make('email')
                ->label('Email')
                ->placeholder('info@example.com')
                ->required();
        }

        // Repeater social media selalu ditampilkan
        $schema[] = Forms\Components\Repeater::make('socials')
            ->label('Social Media')
            ->schema([
                Forms\Components\TextInput::make('link')
                    ->label('Link Sosial Media')
                    ->placeholder('https://tiktok.com/...'),

                Forms\Components\TextInput::make('icon')
                    ->label('Icon')
                    ->placeholder('twitter / facebook / instagram / linkedin / tiktok')
                    ->helperText(new \Illuminate\Support\HtmlString(
                        'Example: <code>&lt;i class="fab fa-tiktok"&gt;&lt;/i&gt;</code><br>
                        Find more icons at <a href="https://fontawesome.com/icons" target="_blank" 
                        class="text-primary-600 underline">Font Awesome</a>'
                    )),
            ])
            ->createItemButtonLabel('Add Social Media')
            ->columns(1);

        // Toggle aktif
        $schema[] = Forms\Components\Toggle::make('is_active')
            ->label('Aktifkan?')
            ->default(true);

        return $form->schema($schema);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\TextColumn::make('label')->sortable(),
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('icon'),
                Tables\Columns\IconColumn::make('is_active')
                ->label('Aktif')
                ->boolean(),
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
            'index' => Pages\ListFooterContacts::route('/'),
            'create' => Pages\CreateFooterContact::route('/create'),
            'edit' => Pages\EditFooterContact::route('/{record}/edit'),
        ];
    }
}
