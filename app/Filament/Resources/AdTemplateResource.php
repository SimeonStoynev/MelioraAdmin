<?php

namespace App\Filament\Resources;

// Models
use App\Models\AdTemplate;

// Illuminate
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Filament
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\AdTemplateResource\Pages;
use App\Filament\Resources\AdTemplateResource\RelationManagers;

class AdTemplateResource extends Resource
{
    protected static ?string $model = AdTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required(),
            Forms\Components\RichEditor::make('description')
                ->columnSpanFull(),
            Forms\Components\TextInput::make('canva_url')
                ->url()
                ->rules(['regex:/^https:\/\/(www\.)?canva\.com\//'])
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'active' => 'Active',
                    'archived' => 'Archived',
                ])
                ->default('draft'),
            Forms\Components\Select::make('ad_id')
                ->relationship('ad', 'title')
                ->required()
                ->searchable(),

            Forms\Components\Section::make('Associated Ad')->visibleOn('view')->schema([
                Forms\Components\Placeholder::make('ad_title')
                    ->label('Ad Title')
                    ->content(fn ($record) => $record?->ad?->title),

                Forms\Components\Placeholder::make('ad_description')
                    ->label('Ad Description')
                    ->content(fn ($record) => $record?->ad?->description),

                Forms\Components\Placeholder::make('ad_url')
                    ->label('Ad URL')
                    ->content(fn ($record) => $record?->ad?->url),

                Forms\Components\Placeholder::make('ad_status')
                    ->label('Ad Status')
                    ->content(fn ($record) => $record?->ad?->status),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\SelectColumn::make('status')
                ->options(['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived']),
            Tables\Columns\TextColumn::make('ad.title')->label('Ad Title'),
            Tables\Columns\TextColumn::make('canva_url')->label('Canva URL')->limit(30),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdTemplates::route('/'),
            'create' => Pages\CreateAdTemplate::route('/create'),
            'edit' => Pages\EditAdTemplate::route('/{record}/edit'),
            'view' => Pages\ViewAdTemplate::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
