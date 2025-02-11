<?php

namespace App\Filament\Resources;

use Actions\Modal;
use Filament\Forms;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Get;
use App\Models\Customer;
use Filament\Forms\Form;
use Actions\CreateAction;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReviewResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReviewResource\RelationManagers;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'carbon-star-review';
    protected static ?string $navigationGroup = 'Reviews';
    public static function canCreate(): bool{
        return false;
     }
     public static function getNavigationBadge(): ?string {
        return static::getModel()::where('users_id', Auth::id())->count();
    }
    protected static ?string $navigationLabel = 'Two Shakes Reviews';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('users_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('location_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('purchase')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('answers')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('review')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('users_id', Auth::id()) )
            ->columns([
            TextColumn::make('customers.fullname')
                    ->label('Customer Name')
                    ->sortable(),
                    TextColumn::make('locations.addr')
                    ->label('Location Reviewed')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rate')
                    ->alignCenter()
                    ->icon('heroicon-o-star')
                    ->iconPosition(IconPosition::After)
                     ->badge()
                     ->color(static function ($state): string {
                        if ($state >= 3 && $state < 5) {
                            return 'violet';
                        }
                        if ($state == 5) {
                            return 'success';
                        }
                        return 'danger';
                        })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('review')
                    ->wrap(),
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
            //    // return [
                Action::make('respond')
                ->button()
                ->form([
                    Hidden::make('users_id')
                        ->formatStateUsing(fn (): string => Auth::id()),
                    Hidden::make('customer_id')
                        ->formatStateUsing(fn (Review $record): string => $record->customers->id),
                    Fieldset::make('Contact Info')
                        ->schema([
                            TextInput::make('first_name')
                                ->formatStateUsing(fn (Review $record): string => $record->customers->first_name)
                                ->label('First Name'),
                            TextInput::make('last_name')
                                ->formatStateUsing(fn (Review $record): string => $record->customers->last_name)
                                ->label('Last Name'),
                            TextInput::make('email')
                                ->formatStateUsing(fn (Review $record): string => $record->customers->email )
                                ->label('Email'),
                        ]),
                    TextInput::make('subject')
                        ->formatStateUsing(fn (): string => 'Thanks for your feedback.' )
                        ->required(),
                    RichEditor::make('body')
                        ->formatStateUsing(fn (): string => 'I just wanted to say how much we appreciate the review you gave us.' )
                        ->autofocus()
                        ->required(),
                ])
                ->action(function (array $data) {
                    ray($data);
                    /* Email to customer, record in CustomerEM table*/
                    // Mail::to($this->client)
                  //  ->bcc($auth()->user()->email)
                    //     ->send(new GenericEmail(
                    //         subject: $data['subject'],
                    //         body: $data['body'],
                    //     ));
                   // CustomerEmail::update([
                //    'users_id' => $data['users_id'],
                //    'customer_id' => $data['customer_id'],
                //    'responded' => true,
                //    'type' => 'thank_you',
                //    'sent' => now(),
                //    ])
                })

                ->slideOver()
            //         Action::make()
            //             ->slideOut(function () {

            //                     // Here you can define the fields if you want to use Filament forms
            //                     // Or you can simply render a Livewire component like this:
            //                      livewire(\App\Livewire\RegisterUser::class)

            //             }),
            //    // ];
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListReviews::route('/'),
            // 'create' => Pages\CreateReview::route('/create'),
            // 'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
