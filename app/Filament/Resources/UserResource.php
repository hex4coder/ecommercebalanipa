<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\AddressRelationManager;
use App\Models\User;
use DateTime;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Data';
    protected static ?string $modelLabel = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'xl' => 2,
                ])->schema([
                    Section::make('Bio Pengguna')
                    ->columns(([
                        'default' => 1,
                        'xl' => 2,
                    ]))
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->label('Nama Pengguna')
                        ->prefixIcon('heroicon-o-user'),
                        TextInput::make('email')
                        ->required()
                        ->email()
                        ->prefixIcon('heroicon-o-envelope'),
                        TextInput::make('password')
                        ->required()
                        ->password()
                        ->revealable()
                        ->prefixIcon('heroicon-o-lock-closed')
                        ->hiddenOn(['edit', 'view']),
                        DateTimePicker::make('email_verified_at')
                        ->label('Tanggal Verifikasi Akun')
                        ->default(now())
                        ->required()
                        ->prefixIcon('heroicon-o-calendar'),
                    ]),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->label('Nama Pengguna')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '0' => 'Administrator',
                        '1' =>  'Customer',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '0' => 'success',
                        '1' => 'warning',
                    })
                    ,
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->toggleable(true, false)
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')->options(
                    [
                        0 => 'Administrator',
                        1 => 'Customer'
                    ]
                ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            AddressRelationManager::class,
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
