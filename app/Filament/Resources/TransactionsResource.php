<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionsResource\Pages;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Contacts Management';
    protected static ?int $navigationSort = 2;
public static function shouldRegisterNavigation(): bool
{
    return false;
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Details')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Transaction Date')
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('Transaction Type')
                            ->options([
                                'send' => 'Send',
                                'receive' => 'Receive',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('send')
                            ->numeric()
                            ->label('Send Amount')
                            ->nullable(),

                        Forms\Components\TextInput::make('receive')
                            ->numeric()
                            ->label('Receive Amount')
                            ->nullable(),

                        Forms\Components\Textarea::make('note')
                            ->rows(2)
                            ->maxLength(255)
                            ->nullable(),

                        Forms\Components\TextInput::make('status')
                            ->default('pending')
                            ->maxLength(50),
                    ])->columns(2),

                Forms\Components\Section::make('Relations')
                    ->schema([
                        Forms\Components\Select::make('userId')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('senderId')
                            ->label('Sender')
                            ->relationship('sender', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('senderCategoryId')
                            ->label('Sender Category')
                            ->relationship('senderCategory', 'name'),

                        Forms\Components\Select::make('senderContactId')
                            ->label('Sender Contact')
                            ->relationship('senderContact', 'name'),

                        Forms\Components\Select::make('receiverUserId')
                            ->label('Receiver')
                            ->relationship('receiverUser', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('receiverCategoryId')
                            ->label('Receiver Category')
                            ->relationship('receiverCategory', 'name'),

                        Forms\Components\Select::make('receiverContactId')
                            ->label('Receiver Contact')
                            ->relationship('receiverContact', 'name'),
                        Forms\Components\Select::make('contact_id')
                            ->relationship('contact', 'name')
                            ->label('Contact')
                            ->required(),

                        Forms\Components\Select::make('sharedUserId')
                            ->label('Shared User')
                            ->relationship('sharedUser', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('sharedCategoryId')
                            ->label('Shared Category')
                            ->relationship('sharedCategory', 'name'),
                    ])->columns(3),

                Forms\Components\TextInput::make('transactionId')
                    ->label('Transaction Ref ID')
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\TextInput::make('typeOriginal')
                    ->label('Original Type')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idtransactions')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('date')->label('Date')->date(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('send')->label('Send'),
                Tables\Columns\TextColumn::make('receive')->label('Receive'),
                Tables\Columns\TextColumn::make('note')->limit(30),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('senderContact.name')->label('Sender Contact'),
                Tables\Columns\TextColumn::make('receiverContact.name')->label('Receiver Contact'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Created'),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}
