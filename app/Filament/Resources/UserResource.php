<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Category;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $navigationIcon = 'lineawesome-users-solid';
    public static function shouldRegisterNavigation(): bool
    {
        return  Auth::user()->isSuper();
    }

    public static function canAccess(): bool
    {
        return  Auth::user()->isSuper();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('company')
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->default(null),
                Forms\Components\TextInput::make('mobile')
                    ->maxLength(20)
                    ->default(null),
                Forms\Components\TextInput::make('min_rate')
                    ->required()
                    ->maxLength(4)
                    ->default(3),
                Forms\Components\Toggle::make('multi_loc')
                    ->required(),
                Forms\Components\TextInput::make('loc_qty')
                    ->required()
                    ->maxLength(4)
                    ->default(1),
                Forms\Components\TextInput::make('support_email')
                    ->email()
                    ->maxLength(45)
                    ->default(null),
                Forms\Components\TextInput::make('category.categories'),
                Forms\Components\TextInput::make('stripe_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('pm_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('pm_last_four')
                    ->maxLength(4)
                    ->default(null),
                Forms\Components\DateTimePicker::make('trial_ends_at'),
                // Forms\Components\TextInput::make('role')
                //     ->required()
                //     ->maxLength(20)
                //     ->default('client'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('company')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('mobile')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('categories.category')
                    ->label('Business Category')

                    ->searchable(),
                TextColumn::make('min_rate')
                    ->searchable(),
                IconColumn::make('multi_loc')
                    ->boolean(),
                TextColumn::make('loc_qty')
                    ->searchable(),
                TextColumn::make('support_email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('subscriptions.stripe_status')
                    ->label('Billing Status')
                    ->searchable(),
                TextColumn::make('stripe_id'),
                TextColumn::make('pm_type')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('pm_last_four')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('trial_ends_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RolesRelationManager::class,
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
