<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SharedResource\Pages;
use App\Models\SharedWith;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SharedResource extends Resource
{
    protected static ?string $model = SharedWith::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Shared With';
    protected static ?string $navigationGroup = 'Contacts Management';
    protected static ?int $navigationSort = 3;
public static function shouldRegisterNavigation(): bool
{
    return false;
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uid')
                    ->label('User UID')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('mobileNo')
                    ->label('Mobile Number')
                    ->maxLength(20)
                    ->nullable(),

                Forms\Components\TextInput::make('imageUrl')
                    ->label('Image URL')
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\Select::make('categoryId')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('contactId')
                    ->label('Contact')
                    ->relationship('contact', 'name')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('receiverContactId')
                    ->label('Receiver Contact')
                    ->relationship('receiverContact', 'name')
                    ->searchable()
                    ->nullable(),

                Forms\Components\DateTimePicker::make('sharedAt')
                    ->label('Shared At')
                    ->default(now()),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idsharedWith')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('username')->label('Username'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('mobileNo')->label('Mobile'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('contact.name')->label('Contact'),
                Tables\Columns\TextColumn::make('receiverContact.name')->label('Receiver Contact'),
                Tables\Columns\TextColumn::make('sharedAt')->label('Shared At')->dateTime(),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShareds::route('/'),
            'create' => Pages\CreateShared::route('/create'),
            'edit' => Pages\EditShared::route('/{record}/edit'),
        ];
    }
}
