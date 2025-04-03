<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

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
use Liamtseva\PGFKEduSystem\Enums\Gender;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Pages\CreateUser;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Pages\EditUser;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use Liamtseva\PGFKEduSystem\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Користувачі';
    protected static ?string $pluralLabel = 'Користувачі';
    protected static ?string $modelLabel = 'користувача';
    protected static ?string $navigationGroup = 'Користувацька активність';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Ім’я')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Введіть ім’я користувача')
                            ->unique(ignoreRecord: true),
                        TextInput::make('email')
                            ->label('Електронна пошта')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('password')
                            ->label('Пароль')
                            ->password()
                            ->required(fn ($record) => !$record)
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->placeholder('Мінімум 8 символів')
                            ->columnSpan(2)
                            ->visibleOn('create'),
                    ]),
                Section::make('Додаткові налаштування')
                    ->icon('heroicon-o-cog')
                    ->collapsible()
                    ->schema([
                        Select::make('role')
                            ->label('Роль')
                            ->options(Role::class)
                            ->required()
                            ->prefixIcon('heroicon-o-identification')
                            ->searchable(),

                        Select::make('gender')
                            ->label('Стать')
                            ->options(Gender::class)
                            ->prefixIcon('bx-male-female'),

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

                        DateTimePicker::make('email_verified_at')
                            ->label('Дата підтвердження пошти')
                            ->displayFormat('d.m.Y H:i')
                            ->hiddenOn('create')
                            ->disabled(),
                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
                TextColumn::make('name')
                    ->label('Ім\'я та пошта')
                    ->description(fn (User $user): string => $user->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Роль')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('gender')
                    ->label('Стать')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')
                    ->label('Дата підтвердження Email')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Фільтр за роллю')
                    ->options(Role::class)
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Тут можна додати зв’язки, наприклад, із Students, Teachers, Admins
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

}
