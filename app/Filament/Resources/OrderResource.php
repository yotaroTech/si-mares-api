<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'הזמנות';
    protected static ?string $modelLabel = 'הזמנה';
    protected static ?string $pluralModelLabel = 'הזמנות';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('פרטי הזמנה')->schema([
                Forms\Components\TextInput::make('order_number')
                    ->label('מספר הזמנה')
                    ->disabled(),
                Forms\Components\TextInput::make('user.name')
                    ->label('לקוח')
                    ->disabled(),
                Forms\Components\TextInput::make('subtotal')
                    ->label('סכום ביניים')
                    ->prefix('₪')
                    ->disabled(),
                Forms\Components\TextInput::make('shipping_cost')
                    ->label('משלוח')
                    ->prefix('₪')
                    ->disabled(),
                Forms\Components\TextInput::make('discount')
                    ->label('הנחה')
                    ->prefix('₪')
                    ->disabled(),
                Forms\Components\TextInput::make('total')
                    ->label('סה"כ')
                    ->prefix('₪')
                    ->disabled(),
                Forms\Components\TextInput::make('payment_method')
                    ->label('אמצעי תשלום')
                    ->disabled(),
                Forms\Components\TextInput::make('payment_reference')
                    ->label('אסמכתא')
                    ->disabled(),
                Forms\Components\TextInput::make('payment_status')
                    ->label('סטטוס תשלום')
                    ->disabled()
                    ->formatStateUsing(fn ($state) => $state instanceof PaymentStatus ? $state->label() : $state),
            ])->columns(2),

            Forms\Components\Section::make('עדכון')->schema([
                Forms\Components\Select::make('status')
                    ->label('סטטוס')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()]))
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('הערות')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('מספר הזמנה')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('לקוח')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('סטטוס')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof OrderStatus ? $state->label() : $state)
                    ->color(fn ($state) => match ($state) {
                        OrderStatus::Pending => 'warning',
                        OrderStatus::Confirmed => 'info',
                        OrderStatus::Processing => 'primary',
                        OrderStatus::Shipped => 'info',
                        OrderStatus::Delivered => 'success',
                        OrderStatus::Cancelled => 'danger',
                        OrderStatus::Refunded => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total')
                    ->label('סה"כ')
                    ->prefix('₪')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('סטטוס תשלום')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof PaymentStatus ? $state->label() : $state)
                    ->color(fn ($state) => match ($state) {
                        PaymentStatus::Pending => 'warning',
                        PaymentStatus::Completed => 'success',
                        PaymentStatus::Failed => 'danger',
                        PaymentStatus::Refunded => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('תאריך')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('סטטוס')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()])),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('סטטוס תשלום')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()])),
                Tables\Filters\Filter::make('created_at')
                    ->label('טווח תאריכים')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('מתאריך'),
                        Forms\Components\DatePicker::make('until')->label('עד תאריך'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
