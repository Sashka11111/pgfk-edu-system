<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Pages;
use Liamtseva\PGFKEduSystem\Models\Specialty;
use Liamtseva\PGFKEduSystem\Enums\Department;

class SpecialtyResource extends Resource
{
    protected static ?string $model = Specialty::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Спеціальності';
    protected static ?string $modelLabel = 'спеціальність';
    protected static ?string $pluralLabel = 'Спеціальності';
    protected static ?string $navigationGroup = 'Освітні налаштування';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Інформація про спеціальність')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва спеціальності')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Введіть назву спеціальності')
                            ->autofocus()
                            ->unique(Specialty::class, 'name',ignoreRecord: true)
                            ->prefixIcon('heroicon-o-identification'),

                        TextInput::make('code')
                            ->label('Код спеціальності')
                            ->required()
                            ->maxLength(3) // Обмежуємо максимальну довжину до 3 символів
                            ->numeric() // Дозволяє вводити лише цифри
                            ->minLength(3) // Вимагає мінімум 3 символи
                            ->placeholder('Введіть 3-значний код')
                            ->unique(Specialty::class, 'code',ignoreRecord: true)
                            ->prefixIcon('heroicon-o-code-bracket'),

                        Select::make('department')
                            ->label('Відділення')
                            ->required()
                            ->options(Department::class)
                            ->searchable()
                            ->prefixIcon('heroicon-o-building-office'),

                        RichEditor::make('description')
                            ->label('Опис спеціальності')
                            ->nullable()
                            ->disableToolbarButtons(['attachFiles'])
                            ->placeholder('Введіть опис спеціальності')
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

                TextColumn::make('code')
                    ->label('Код спеціальності')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Назва спеціальності')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('department')
                    ->label('Відділення')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
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
                SelectFilter::make('department')
                    ->label('Фільтр за відділенням')
                    ->options(Department::class)
                    ->placeholder('Оберіть відділення'),
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

    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed, e.g., for groups
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecialties::route('/'),
            'create' => Pages\CreateSpecialty::route('/create'),
            'edit' => Pages\EditSpecialty::route('/{record}/edit'),
        ];
    }
}
