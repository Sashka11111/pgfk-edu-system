<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Enums\Position;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Pages\CreateWorker;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Pages\EditWorker;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\WorkerResource\Pages\ListWorkers;
use Liamtseva\PGFKEduSystem\Models\User;
use Liamtseva\PGFKEduSystem\Models\Worker;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Працівники';
    protected static ?string $modelLabel = 'працівника';
    protected static ?string $pluralLabel = 'Працівники';
    protected static ?string $navigationGroup = 'Навчальний процес';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $isWorker = auth()->user() && auth()->user()->role === Role::ADMIN;
        return $form
            ->schema([
                Section::make('Особисті дані')
                    ->description('Основна інформація про працівника')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('last_name')
                            ->label('Прізвище')
                            ->required()
                            ->minLength(2)
                            ->maxLength(50),

                        TextInput::make('first_name')
                            ->label("Ім'я")
                            ->required()
                            ->minLength(2)
                            ->maxLength(50),

                        TextInput::make('middle_name')
                            ->label('По батькові')
                            ->nullable()
                            ->minLength(2)
                            ->maxLength(50),

                        Select::make('user_id')
                            ->label('Користувач')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->live() // Робимо поле реактивним
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Оновлюємо поле email на основі вибраного user_id
                                if ($state) {
                                    $user = User::find($state);
                                    $set('email', $user?->email);
                                } else {
                                    $set('email', null); // Очищаємо, якщо користувач не вибраний
                                }
                            })
                            ->placeholder('Оберіть користувача')
                            ->prefixIcon('heroicon-o-user-circle')
                            ->disabled($isWorker),

                        TextInput::make('email')
                            ->label('Пошта')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-envelope'),

                        Select::make('position')
                            ->label('Посада')
                            ->options(Position::class)
                            ->required()
                            ->prefixIcon('heroicon-o-briefcase'),

                        DateTimePicker::make('created_at')
                            ->label('Дата створення')
                            ->prefixIcon('heroicon-o-calendar')
                            ->displayFormat('d.m.Y H:i')
                            ->disabled()
                            ->default(now())
                            ->hiddenOn('create'),

                        DateTimePicker::make('updated_at')
                            ->label('Дата оновлення')
                            ->prefixIcon('heroicon-o-clock')
                            ->displayFormat('d.m.Y H:i')
                            ->disabled()
                            ->default(now())
                            ->hiddenOn('create'),
                    ])
                    ->columns(2),

                Section::make('Контактні дані')
                    ->description('Додаткова інформація про працівника')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextInput::make('phone_number')
                            ->label('Номер телефону')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->placeholder('+38 (XXX) XXX-XX-XX')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Worker::query()->with('user'))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('last_name')
                    ->label('ПІБ')
                    ->sortable()
                    ->searchable()
                    ->description(function ($record) {
                        return "{$record->first_name} {$record->middle_name}";
                    })
                    ->toggleable(),

                TextColumn::make('position')
                    ->label('Посада')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone_number')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Пошта')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.gender')
                    ->label('Стать')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('position')
                    ->label('Фільтр за посадою')
                    ->options(Position::class)
                    ->placeholder('Оберіть посаду'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->icon('heroicon-o-trash'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkers::route('/'),
            'create' => CreateWorker::route('/create'),
            'edit' => EditWorker::route('/{record}/edit'),
        ];
    }
}
