<?php

namespace Liamtseva\PGFKEduSystem\Filament\Home\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Enums\Role;
use Liamtseva\PGFKEduSystem\Filament\Home\Pages\Dashboard;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\CreateStudent;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\EditStudent;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\ListStudents;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\ViewStudent;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\User;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Студенти';
    protected static ?string $modelLabel = 'студента';
    protected static ?string $pluralLabel = 'Студенти';
    protected static ?string $navigationGroup = 'Навчальний процес';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $isStudent = auth()->user() && auth()->user()->role === Role::STUDENT;

        return $form
            ->schema([
                Section::make('Особисті дані')
                    ->description('Основна інформація про студента')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('last_name')
                            ->label('Прізвище')
                            ->required()
                            ->minLength(2)
                            ->maxLength(50)
                            ->disabled($isStudent),

                        TextInput::make('first_name')
                            ->label("Ім'я")
                            ->required()
                            ->minLength(2)
                            ->maxLength(50)
                            ->disabled($isStudent),

                        TextInput::make('middle_name')
                            ->label('По батькові')
                            ->nullable()
                            ->minLength(2)
                            ->maxLength(50)
                            ->disabled($isStudent),

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
                            ->disabled($isStudent),

                        TextInput::make('email')
                            ->label('Пошта')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-envelope'),

                        TextInput::make('record_book_number')
                            ->label('Номер залікової книжки')
                            ->required()
                            ->maxLength(10)
                            ->minLength(10)
                            ->unique(Student::class, 'record_book_number', ignoreRecord: true)
                            ->prefixIcon('heroicon-o-book-open')
                            ->disabled($isStudent),

                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->searchable()
                            ->required()
                            ->preload()
                            ->placeholder('Оберіть групу')
                            ->prefixIcon('heroicon-o-users')
                            ->disabled($isStudent),

                        DatePicker::make('enrollment_date')
                            ->label('Дата вступу')
                            ->required()
                            ->displayFormat('d.m.Y')
                            ->prefixIcon('heroicon-o-calendar')
                            ->disabled($isStudent),
                    ])
                    ->columns(2),

                Section::make('Додаткова інформація')
                    ->description('Академічні та контактні дані')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Select::make('subjects')
                            ->label('Незараховані предмети')
                            ->relationship('subjects', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->placeholder('Оберіть предмети')
                            ->prefixIcon('heroicon-o-book-open')
                            ->disabled($isStudent),

                        Toggle::make('is_scholarship_holder')
                            ->label('Отримує стипендію')
                            ->default(false)
                            ->disabled($isStudent),

                        TextInput::make('birthplace')
                            ->label('Місце народження')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-map-pin')
                            ->disabled($isStudent),

                        DatePicker::make('birthdate')
                            ->label('Дата народження')
                            ->default(now())
                            ->displayFormat('d.m.Y')
                            ->prefixIcon('heroicon-o-cake')
                            ->disabled($isStudent),

                        TextInput::make('phone_number')
                            ->label('Номер телефону')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX')
                            ->disabled($isStudent),

                        TextInput::make('address')
                            ->label('Адреса')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-home')
                            ->disabled($isStudent),

                        TextInput::make('guardian_name')
                            ->label('Ім\'я опікуна')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user-group')
                            ->disabled($isStudent),

                        TextInput::make('guardian_phone')
                            ->label('Телефон опікуна')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX')
                            ->disabled($isStudent),

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
            ]);
    }

    public static function table(Table $table): Table
    {
        // Таблиця доступна лише для студентів
        if (auth()->user() && auth()->user()->role === Role::STUDENT) {
            abort(403, "Доступ до списку студентів заборонено.");
        }

        $query = Student::query()->with(['user', 'group']);

        return $table
            ->query($query)
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

                TextColumn::make('record_book_number')
                    ->label('Номер особової справи')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('group.name')
                    ->label('Група')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->default('Не вказано'),

                TextColumn::make('enrollment_date')
                    ->label('Дата вступу')
                    ->date('d.m.Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('subjects.name')
                    ->label('Незараховані предмети')
                    ->badge()
                    ->limitList(2)
                    ->tooltip(fn ($record) => $record->subjects->pluck('name')->join(', '))
                    ->separator(', ')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('is_scholarship_holder')
                    ->label('Стипендія')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('birthdate')
                    ->label('Дата народження')
                    ->date('d.m.Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone_number')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                TextColumn::make('birthplace')
                    ->label('Місце народження')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('address')
                    ->label('Адреса')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('guardian_name')
                    ->label('Ім\'я опікуна')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('guardian_phone')
                    ->label('Телефон опікуна')
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
                SelectFilter::make('group_id')
                    ->label('Фільтр за групою')
                    ->options(function () {
                        return Group::pluck('name', 'id')->all();
                    })
                    ->placeholder('Оберіть групу'),

                SelectFilter::make('is_scholarship_holder')
                    ->label('Фільтр за стипендією')
                    ->options([
                        '1' => 'Отримує стипендію',
                        '0' => 'Не отримує стипендію',
                    ]),
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
        // Для студентів доступна лише сторінка перегляду їхнього запису
        if (auth()->user() && auth()->user()->role === Role::STUDENT) {
            $student = Student::where('user_id', auth()->id())->first();
            if ($student) {
                return [
                    'view' => ViewStudent::route('/{record}'),
                ];
            }
            return [];
        }

        // Для інших ролей доступні всі сторінки
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
            'view' => ViewStudent::route('/{record}'),
        ];
    }

    /**
     * Налаштування URL для пункту меню "Студенти"
     */
    public static function getNavigationUrl(): string
    {
        if (auth()->check() && auth()->user()->role === Role::STUDENT) {
            $student = Student::where('user_id', auth()->id())->first();
            if ($student) {
                return static::getUrl('view', ['record' => $student->id]);
            }
            // Якщо студент не знайдений, кидаємо помилку 403
            abort(403, 'Доступ до списку студентів заборонено.');
        }

        return static::getUrl(Dashboard::class); // Для інших ролей
    }
}
