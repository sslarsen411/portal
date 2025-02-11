<?php
//
//namespace App\Filament\Resources;
//
//use Filament\Forms;
//use Filament\Tables;
//use App\Models\Contact;
//use Filament\Forms\Get;
//use Filament\Forms\Form;
//use Filament\Tables\Table;
//use Filament\Resources\Resource;
//use Filament\Forms\Components\Radio;
//use Illuminate\Support\Facades\Auth;
//use Filament\Forms\Components\Hidden;
//use Filament\Forms\Components\Fieldset;
//use Filament\Tables\Columns\IconColumn;
//use Filament\Tables\Columns\TextColumn;
//use Filament\Forms\Components\TextInput;
//use Illuminate\Database\Eloquent\Builder;
//use App\Filament\Resources\ContactResource\Pages;
//use Illuminate\Database\Eloquent\SoftDeletingScope;
//use App\Filament\Resources\ContactResource\RelationManagers;
//
//class ContactResource extends Resource
//{
//    protected static ?string $model = Contact::class;
//
//    public static function canCreate(): bool
//    {
//        return false;
//    }
//    protected static bool $shouldRegisterNavigation = false;    protected static ?string $navigationIcon = 'fluentui-building-retail-20-o';
//    protected static ?string $navigationLabel = 'Business Info';
//    protected static ?string $navigationGroup = 'Account';
//    public static function form(Form $form): Form{
//        return $form
//        ->schema([
//            Hidden::make('users_id')
//                ->default(Auth::id()),
//            Fieldset::make('Your Business Info')
//                ->schema([
//                TextInput::make('company')
//                    ->label('Company Name')
//                    ->columnSpan(2)
//                    ->required()
//                    ->markAsRequired(false)
//                    ->maxLength(50),
//                TextInput::make('ctc_phone')
//                    ->label('Your Contact Phone')
//                    ->tel()
//                    ->maxLength(20)
//                    ->markAsRequired(false)
//                    ->required(),
//                TextInput::make('ctc_mobile')
//                    ->label('Your Cell (optional)')
//                   // ->mask('(999) 999-9999')
//                    ->tel()
//                    ->maxLength(20)
//                    ->default(null),
//                ])
//                ->columns(2),
//                Fieldset::make('Your Google Business Profile Locations')
//                    ->schema([
//                    Radio::make('multi_loc')
//                    ->disabled()
//                        ->label('More than one?')
//                        ->helperText('Do you have more than one Google Business Profile location?')
//                        //->columnSpan(2)
//                        ->inline()
//                        ->boolean()
//                        ->live()
//                        ->default(false),
//                    TextInput::make('loc_qty')
//                        ->label('How many GPB locations do you have?')
//                        ->disabled(),
//                ])
//                ->columns(2),
//
//                Fieldset::make('How many stars for a positive review?')
//                ->schema([
//                    TextInput::make('min_rate')
//                    ->label('Minimum review rating')
//                    ->required()
//                    ->default(3),
//                ])
//        ]);
//    }
//    public static function table(Table $table): Table{
//        return $table
//        ->modifyQueryUsing(fn (Builder $query) =>
//            $query->where('users_id', Auth::id()))
//        ->heading('Account')
//        ->columns([
//            TextColumn::make('users_id')
//                ->hidden(),
//            TextColumn::make('users.name')
//                ->label('Owner'),
//            TextColumn::make('company')
//                ->sortable()
//                ->searchable(),
//            TextColumn::make('locations.addr')
//                ->label('GBP Locations')
//                ->listWithLineBreaks()
//                ->bulleted()
//                ->searchable(),
//            TextColumn::make('subscriptions.stripe_status')
//                ->label('Status'),
//            TextColumn::make('ctc_phone')
//                ->label('Contact Phone')
//                ->formatStateUsing(fn (string $state) => fromE164($state))
//                ->searchable(),
//            TextColumn::make('ctc_mobile')
//                ->label('Contact Cell')
//                ->formatStateUsing(fn (string $state) => fromE164($state))
//                ->searchable(),
//           TextColumn::make('min_rate')
//                ->searchable(),
//           IconColumn::make('multi_loc')
//                ->boolean(),
//           TextColumn::make('loc_qty')
//                ->label('Max locations'),
//             //   ->hidden(fn (Get $get): bool => ! $get('multi_loc')),
//           TextColumn::make('loc_to_add')
//
//                ->searchable(),
//           TextColumn::make('created_at')
//                ->dateTime()
//                ->sortable()
//                ->toggleable(isToggledHiddenByDefault: true),
//           TextColumn::make('updated_at')
//                ->dateTime()
//                ->sortable()
//                ->toggleable(isToggledHiddenByDefault: true),
//        ])
//            ->filters([
//                //
//            ])
//            ->actions([
//                Tables\Actions\EditAction::make()
//                    ->slideOver(),
//            ])
//            ->bulkActions([
//                // Tables\Actions\BulkActionGroup::make([
//                //     Tables\Actions\DeleteBulkAction::make(),
//                // ]),
//            ]);
//    }
//
//    public static function getRelations(): array
//    {
//        return [
//            //
//        ];
//    }
//
//    public static function getPages(): array
//    {
//        return [
//          //  'index' => Pages\ListContacts::route('/'),
//         //   'create' => Pages\CreateContact::route('/create'),
//         //   'edit' => Pages\EditContact::route('/{record}/edit'),
//        ];
//    }
//}
