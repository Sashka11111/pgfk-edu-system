<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Pages\CreateCourse;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Pages\EditCourse;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\CourseResource\Pages\ListCourses;
use Liamtseva\PGFKEduSystem\Models\Course;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // Іконка для курсів

    protected static ?string $navigationLabel = 'Курси'; // Назва в навігації
    protected static ?string $modelLabel = 'курс';
    protected static ?string $pluralLabel = 'Курси'; // Назва у множині
    protected static ?string $navigationGroup = 'Освітні налаштування';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Введіть основні дані про курс')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва курсу')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Введіть назву курсу')
                            ->prefixIcon('heroicon-o-identification'),

                        TextInput::make('hours')
                            ->label('Кількість годин')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->placeholder('Вкажіть кількість годин'),

                        RichEditor::make('description')
                            ->label('Опис курсу')
                            ->nullable()
                            ->disableToolbarButtons(['attachFiles'])
                            ->placeholder('Опишіть курс детально')
                            ->columnSpanFull(),

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
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Назва курсу')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('hours')
                    ->label('Годин')
                    ->alignCenter()
                    ->icon('heroicon-o-clock')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('hours')
                    ->label('Фільтр за годинами')
                    ->options([
                        'less_than_50' => 'Менше 50 годин',
                        '50_to_100' => '50-100 годин',
                        'more_than_100' => 'Більше 100 годин',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'less_than_50') {
                            $query->where('hours', '<', 50);
                        } elseif ($data['value'] === '50_to_100') {
                            $query->whereBetween('hours', [50, 100]);
                        } elseif ($data['value'] === 'more_than_100') {
                            $query->where('hours', '>', 100);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'), // Іконка видалення
                ]),
            ])
            ->defaultSort('created_at', 'desc'); // Сортування за датою створення
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
