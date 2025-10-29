<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
       protected static ?int $navigationSort = -99; 
    protected static ?string $slug = 'users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('mobileNo')
                            ->label('Mobile Number')
                            ->tel()
                            ->maxLength(20)
                            ->nullable(),

                        Forms\Components\FileUpload::make('imageUrl')
                            ->label('Profile Image')
                            ->image()
                            ->directory('user-images')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->nullable(),


                    ])
                    ->columns(2),
            ]);
    }

public static function table(Table $table): Table
{
    return $table
      ->recordUrl(null)
        ->columns([
            Tables\Columns\ImageColumn::make('imageUrl')
                ->label('Image')
                ->circular()
                ->height(50)
                ->width(50),

            Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable(),

            Tables\Columns\TextColumn::make('mobileNo')
                ->label('Mobile Number'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('d M Y, h:i A')
                ->sortable(),


        ])
        ->actions([
            Tables\Actions\Action::make('view')
                ->label('View Details')
                ->icon('heroicon-o-eye')
                ->modalHeading('User Details')
                ->modalButton('Close')
                ->modalWidth('3xl')
                ->form([
                    Forms\Components\Tabs::make('User Info')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Profile')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->label('Full Name')->disabled(),
                                    Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                                    Forms\Components\TextInput::make('mobileNo')->label('Mobile')->disabled(),
                                    Forms\Components\FileUpload::make('imageUrl')->label('Profile Image')->disabled(),
                                ]),
                            Forms\Components\Tabs\Tab::make('Categories')
                                ->schema([
                      
                                ]),
                            Forms\Components\Tabs\Tab::make('Transaction')
                                ->schema([
                             
                                ]),
                            Forms\Components\Tabs\Tab::make('Shared with')
                                ->schema([
                             
                                ]),
                            Forms\Components\Tabs\Tab::make('Contacts')
                                ->schema([
                             
                                ]),
                        ]),
                ])
                ->fillForm(fn ($record) => $record->toArray()),

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
            // Later you can add RelationManagers here (e.g., contacts, categories, transactions)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
