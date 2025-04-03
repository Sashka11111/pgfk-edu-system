<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Enums\StudyForm;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource\Pages\CreateGroup;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource\Pages\EditGroup;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\GroupResource\Pages\ListGroups;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\Specialty;
use Liamtseva\PGFKEduSystem\Models\Teacher;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Групи';
    protected static ?string $modelLabel = 'групу';
    protected static ?string $pluralLabel = 'Групи';
    protected static ?string $navigationGroup = 'Освітні налаштування';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про групу')
                    ->description('Основні дані про навчальну групу')
                    ->icon('heroicon-o-rectangle-stack')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва групи')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Введіть назву групи (наприклад, АА-11)')
                            ->autofocus()
                            ->unique(Group::class, 'name',ignoreRecord: true)
                            ->prefixIcon('heroicon-o-identification')
                            ->hint('Назва має бути унікальною'),

                        Select::make('year_of_study')
                            ->label('Рік навчання')
                            ->options([
                                1 => '1-й рік',
                                2 => '2-й рік',
                                3 => '3-й рік',
                                4 => '4-й рік',
                            ])
                            ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-calendar'),

                        Select::make('specialty_id')
                            ->label('Спеціальність')
                            ->relationship('specialty', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Оберіть спеціальність')
                            ->prefixIcon('heroicon-o-book-open'),

                        Select::make('study_form')
                            ->label('Форма навчання')
                            ->required()
                            ->options(StudyForm::class)
                            ->searchable()
                            ->prefixIcon('heroicon-o-briefcase'),

                        Select::make('teacher_id')
                            ->label('Куратор')
                            ->options(function () {
                                return Teacher::with('user')
                                    ->get()
                                    ->pluck('user.name', 'id')
                                    ->all();
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Оберіть куратора')
                            ->prefixIcon('heroicon-o-user'),

                        Select::make('subjects')
                            ->label('Предмети')
                            ->relationship('subjects', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->placeholder('Оберіть предмети')
                            ->prefixIcon('heroicon-o-book-open'),

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
            ->query(Group::query()->with(['teacher.user']))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Назва групи')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('year_of_study')
                    ->label('Рік навчання')
                    ->formatStateUsing(fn ($state) => "{$state}-й рік")
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('specialty.name')
                    ->label('Спеціальність')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->default('Не вказано'),

                TextColumn::make('study_form')
                    ->label('Форма навчання')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('teacher')
                    ->label('Куратор')
                    ->formatStateUsing(fn ($record) => $record->teacher?->user?->name ?? 'Не призначено')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->default('Не призначено'),

                TextColumn::make('subjects.name')
                    ->label('Предмети')
                    ->badge()
                    ->limitList(2)
                    ->tooltip(fn ($record) => $record->subjects->pluck('name')->join(', '))
                    ->separator(', ')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

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
                SelectFilter::make('year_of_study')
                    ->label('Фільтр за роком навчання')
                    ->options([
                        1 => '1-й рік',
                        2 => '2-й рік',
                        3 => '3-й рік',
                        4 => '4-й рік',
                    ]),
                SelectFilter::make('specialty_id')
                    ->label('Фільтр за спеціальністю')
                    ->options(function () {
                        return Specialty::pluck('name', 'id')->all();
                    })
                    ->placeholder('Оберіть спеціальність'),
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
            // Тут можна додати відношення, наприклад до студентів
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }
}
