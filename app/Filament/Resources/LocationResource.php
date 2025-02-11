<?php

namespace App\Filament\Resources;

use App\Traits\SiteHelpers;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LocationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    use SiteHelpers;

    protected static ?string $model = Location::class;
    public static function canCreate(): bool{
        return false;
     }
     protected static ?int $navigationSort = 1;
     protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationIcon = 'lineawesome-store-alt-solid';
    public static function getNavigationBadge(): ?string {
        return static::getModel()::where('users_id', Auth::id())->count();
    }
    protected ?string $heading = 'Custom Page Heading';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('users_id')
                    ->default(Auth::id()),
                Section::make('Location Info. All fields are required.')
                ->schema([
                    TextInput::make('addr')
                        ->label('Street address')
                        ->columnSpan(4)
                        ->required()
                        ->markAsRequired(false)
                        ->maxLength(50),
                    TextInput::make('city')
                        ->label('City')
                        ->string()
                        ->required()
                        ->markAsRequired(false)
                        ->maxLength(50)
                        ->default(null),
                    TextInput::make('state')
                        ->label('State')
                        ->string()
                        ->required()
                        ->markAsRequired(false)
                        ->maxLength(2)
                        ->default(null),
                    TextInput::make('zip')
                        ->label('Zip code')
                        ->required()
                        ->markAsRequired(false)
                        ->maxLength(5),
                    TextInput::make('loc_phone')
                        ->label('Location phone')
                        ->maxLength(45)
                        ->markAsRequired(false)
                        ->required(),
                ])
                ->columns(4),
                Forms\Components\TextInput::make('CID')
                    ->label('Google CID')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('PID')
                ->label('Google PID')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\TextInput::make('init_rate')
                    ->label('Initial Review Avg.')
                    ->maxLength(4)
                    ->default(null),
                Forms\Components\TextInput::make('init_rct')
                    ->label('Initial Review Count')
                    ->maxLength(10)
                    ->default(null),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if(! auth()->user()->isSuper()){
                    $query->where('users_id', Auth::id());
                }
                 return $query;
            })
            ->columns([
                TextColumn::make('addr')
                    ->label('Address')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('zip')
                    ->searchable(),
                TextColumn::make('loc_phone')
                    ->label('Phone')
                    ->formatStateUsing(fn (string $state) => self::fromE164($state))
                    ->searchable(),
                TextColumn::make('loc_email')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('CID')
                    ->label('Google CID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('PID')
                    ->label('Google Places ID')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                    'active' => 'teal',
                    'inactive' => 'danger',
                    }),
                TextColumn::make('init_rate')
                    ->label('Initial Review Avg.')
                    ->searchable(),
                TextColumn::make('init_rct')
                    ->label('Initial Review Count')
                    ->searchable(),
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
                 Tables\Actions\EditAction::make()
                 ->visible(fn ( $record): bool => auth()->user()->isSuper()),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
            'update' => Pages\UpdateLocations::route('/update'),
        ];
    }
}
