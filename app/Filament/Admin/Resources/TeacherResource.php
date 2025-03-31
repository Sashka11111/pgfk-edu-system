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
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Enums\Department;
use Liamtseva\PGFKEduSystem\Enums\Qualification;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\CreateTeacher;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\EditTeacher;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\ListTeachers;
use Liamtseva\PGFKEduSystem\Models\Teacher;
use Liamtseva\PGFKEduSystem\Models\User;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'fas-chalkboard-teacher';
    protected static ?string $navigationLabel = 'Викладачі';
    protected static ?string $modelLabel = 'викладача';
    protected static ?string $pluralLabel = 'Викладачі';
    protected static ?string $navigationGroup = 'Навчальний процес';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Особисті дані')
                    ->description('Основна інформація про викладача')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->label('Користувач')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('ПІБ')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(User::class, 'email'),
                                TextInput::make('password')
                                    ->label('Пароль')
                                    ->password()
                                    ->required()
                                    ->default(Str::random(12)),
                            ])
                            ->placeholder('Оберіть користувача')
                            ->prefixIcon('heroicon-o-user-circle'),

                        Select::make('qualification')
                            ->label('Кваліфікація')
                            ->options(Qualification::class)
                            ->required()
                            ->prefixIcon('heroicon-o-academic-cap'),

                        Select::make('subjects')
                            ->label('Предмети')
                            ->relationship('subjects', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->placeholder('Оберіть предмети')
                            ->prefixIcon('heroicon-o-book-open'),
                    ])
                    ->columns(2),

                Section::make('Контактні дані')
                    ->description('Додаткова інформація про викладача')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextInput::make('phone_number')
                            ->label('Номер телефону')
                            ->tel()
                            ->maxLength(13)
                            ->minLength(13)
                            ->prefixIcon('heroicon-o-phone')
                            ->hint('Формат: +38 (XXX) XXX-XX-XX')
                            ->nullable(),

                        TextInput::make('experience_years')
                            ->label('Досвід роботи (роки)')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Teacher::query()->with('user'))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name')
                    ->label('ПІБ')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('qualification')
                    ->label('Кваліфікація')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('subjects.name')
                    ->label('Предмети')
                    ->badge()
                    ->limitList(2)
                    ->tooltip(fn ($record) => $record->subjects->pluck('name')->join(', '))
                    ->separator(', ')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone_number')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('experience_years')
                    ->label('Досвід (роки)')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

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
                SelectFilter::make('qualification')
                    ->label('Фільтр за кваліфікацією')
                    ->options(Qualification::class)
                    ->placeholder('Оберіть кваліфікацію'),

                SelectFilter::make('department')
                    ->label('Фільтр за кафедрою')
                    ->options(Department::class)
                    ->placeholder('Оберіть кафедру'),
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
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}
