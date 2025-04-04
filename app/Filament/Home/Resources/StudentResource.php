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
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Enums\Gender;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\CreateStudent;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\EditStudent;
use Liamtseva\PGFKEduSystem\Filament\Home\Resources\StudentResource\Pages\ListStudents;
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
                            ->placeholder('Оберіть користувача')
                            ->prefixIcon('heroicon-o-user-circle'),

                        TextInput::make('record_book_number')
                            ->label('Номер залікової книжки')
                            ->required()
                            ->maxLength(10)
                            ->minLength(10)
                            ->unique(Student::class, 'record_book_number', ignoreRecord: true)
                            ->prefixIcon('heroicon-o-book-open')
                            ->hint('Має бути унікальним'),

                        Select::make('group_id')
                            ->label('Група')
                            ->relationship('group', 'name')
                            ->searchable()
                            ->required()
                            ->preload()
                            ->placeholder('Оберіть групу')
                            ->prefixIcon('heroicon-o-users'),

                        DatePicker::make('enrollment_date')
                            ->label('Дата вступу')
                            ->required()
                            ->displayFormat('d.m.Y')
                            ->prefixIcon('heroicon-o-calendar'),
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
                            ->prefixIcon('heroicon-o-book-open'),

                        Toggle::make('is_scholarship_holder')
                            ->label('Отримує стипендію')
                            ->default(false),

                        TextInput::make('birthplace')
                            ->label('Місце народження')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-map-pin'),

                        DatePicker::make('birthdate')
                            ->label('Дата народження')
                            ->default(now())
                            ->displayFormat('d.m.Y')
                            ->prefixIcon('heroicon-o-cake'),

                        TextInput::make('phone_number')
                            ->label('Номер телефону')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX'),


                        TextInput::make('address')
                            ->label('Адреса')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-home'),

                        TextInput::make('guardian_name')
                            ->label('Ім\'я опікуна')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user-group'),

                        TextInput::make('guardian_phone')
                            ->label('Телефон опікуна')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX'),
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
        return $table
            ->query(Student::query()->with(['user', 'group']))
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

                TextColumn::make('user.email')
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
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
