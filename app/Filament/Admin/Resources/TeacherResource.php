<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Resources\TeacherResource\Pages;
use Liamtseva\PGFKEduSystem\Filament\Resources\TeacherResource\RelationManagers;
use Liamtseva\PGFKEduSystem\Models\Teacher;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\ListTeachers::route('/'),
            'create' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\CreateTeacher::route('/create'),
            'edit' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\TeacherResource\Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
