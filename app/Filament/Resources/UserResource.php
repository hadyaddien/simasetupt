<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $navigationLabel = 'Manage Data Users';
    protected static ?int $navigationSort = 2;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required(),

                TextInput::make('nip')
                    ->label('Registration number(NIP)')
                    ->unique(ignoreRecord: true),

                Select::make('division_id')
                    ->label('Division')
                    ->relationship('division', 'division_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('division_name')
                            ->label('Division Name')
                            ->required(),
                    ])
                    ->required(),

                Select::make('roles')
                    ->label('Role')
                    ->options(User::getRoleOptions())
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),


                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(),

                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->label('Registration number(NIP)')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('division.division_name')
                    ->label('Division')
                    ->sortable(),

                TextColumn::make('roles')
                    ->label('Role')
                    ->sortable(),

                // TextColumn::make('created_at')
                //     ->label('Created At')
                //     ->dateTime()
                //     ->sortable(),

                // TextColumn::make('updated_at')
                //     ->label('Updated At')
                //     ->since()
                //     ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('division_id')
                    ->relationship('division', 'division_name')
                    ->label('Filter by Division'),
            ])
            ->actions([
                // ActionGroup::make([
                ViewAction::make(),
                // EditAction::make(),
                DeleteAction::make(),
                // ])
                // ->button()
                // ->label('Actions')
                // ->size(ActionSize::Small),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
