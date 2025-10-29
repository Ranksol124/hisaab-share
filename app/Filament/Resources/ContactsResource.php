<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactsResource\Pages;
use App\Models\Contacts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactsResource extends Resource
{
    protected static ?string $model = Contacts::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Contacts Management';
    protected static ?int $navigationSort = -1;
public static function shouldRegisterNavigation(): bool
{
    return false;
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('mobileNo')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Sharing Details')
                    ->schema([
                        Forms\Components\Toggle::make('isSharedView')
                            ->label('Shared View')
                            ->default(false),

                        Forms\Components\Toggle::make('allowReceiverToAddTransactions')
                            ->label('Allow Receiver To Add Transactions')
                            ->default(true),

                        Forms\Components\TextInput::make('sharedUserId')
                            ->label('Shared User ID')
                            ->numeric()
                            ->nullable(),

                        Forms\Components\TextInput::make('sharedCategoryId')
                            ->label('Shared Category ID')
                            ->numeric()
                            ->nullable(),

                        Forms\Components\TextInput::make('originalContactId')
                            ->label('Original Contact ID')
                            ->numeric()
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Shared By Information')
                    ->schema([
                        Forms\Components\TextInput::make('sharedBy_name')->maxLength(255),
                        Forms\Components\TextInput::make('sharedBy_email')->maxLength(255),
                        Forms\Components\TextInput::make('sharedBy_mobileNo')->maxLength(255),
                        Forms\Components\TextInput::make('sharedBy_imageUrl')->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('mobileNo')->label('Mobile'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('amount')->sortable(),
                Tables\Columns\IconColumn::make('isSharedView')->boolean(),
                Tables\Columns\IconColumn::make('allowReceiverToAddTransactions')->label('Allow Transactions ')->boolean(),
                Tables\Columns\TextColumn::make('sharedBy_name')->label('Shared By'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContacts::route('/create'),
            'edit' => Pages\EditContacts::route('/{record}/edit'),
        ];
    }
}
