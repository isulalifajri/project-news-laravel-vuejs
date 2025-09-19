<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Post Info')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($operation, $state, Set $set) {
                                if ($operation === 'edit') return;
                                $slug = Str::slug($state);
                                while (Post::where('slug', $slug)->exists()) {
                                    $slug .= '-' . rand(1, 9) . Str::lower(Str::random(2));
                                }
                                $set('slug', $slug);
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->readOnly(),

                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),

                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => auth('backend')->id()),

                        Forms\Components\TextInput::make('author_name')
                            ->label('Author')
                            ->default(fn () => auth('backend')->user()?->name)
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record) {
                                    $component->state($record->backendUser?->name); 
                                }
                            })
                            ->readOnly()
                            ->dehydrated(false),

                            Forms\Components\FileUpload::make('thumbnail')
                                ->image()
                                ->directory('thumbnails')
                                ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                                ->disk('public')
                                ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file)),

                    ]),

                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Meta')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft'),

                        Forms\Components\DateTimePicker::make('published_at')->default(now()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->disk('public')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('backendUser.name')->label('Author'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('published_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ]),
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
