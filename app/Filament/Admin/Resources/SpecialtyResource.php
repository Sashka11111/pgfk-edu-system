<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Resources\SpecialtyResource\Pages;
use Liamtseva\PGFKEduSystem\Filament\Resources\SpecialtyResource\RelationManagers;
use Liamtseva\PGFKEduSystem\Models\Specialty;

class SpecialtyResource extends Resource
{
    protected static ?string $model = Specialty::class;

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
            'index' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Pages\ListSpecialties::route('/'),
            'create' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Pages\CreateSpecialty::route('/create'),
            'edit' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\SpecialtyResource\Pages\EditSpecialty::route('/{record}/edit'),
        ];
    }
}
