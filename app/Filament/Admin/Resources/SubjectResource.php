<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SubjectResource\Pages\CreateSubject;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SubjectResource\Pages\EditSubject;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SubjectResource\Pages\ListSubjects;
use Liamtseva\PGFKEduSystem\Models\Subject;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // Іконка для курсів

    protected static ?string $navigationLabel = 'Предмети'; // Назва в навігації
    protected static ?string $modelLabel = 'предмет';
    protected static ?string $pluralLabel = 'Предмети'; // Назва у множині
    protected static ?string $navigationGroup = 'Освітні налаштування';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основна інформація')
                    ->description('Введіть основні дані про предмет')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва предмета')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Введіть назву предмета')
                            ->prefixIcon('heroicon-o-identification'),

                        TextInput::make('hours')
                            ->label('Кількість годин')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->placeholder('Вкажіть кількість годин'),

                        RichEditor::make('description')
                            ->label('Опис предмета')
                            ->nullable()
                            ->disableToolbarButtons(['attachFiles'])
                            ->placeholder('Опишіть предмет детально')
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
                    ->label('Назва предмета')
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubjects::route('/'),
            'create' => CreateSubject::route('/create'),
            'edit' => EditSubject::route('/{record}/edit'),
        ];
    }
}
