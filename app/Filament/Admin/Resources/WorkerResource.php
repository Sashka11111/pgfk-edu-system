<?php

namespace Liamtseva\PGFKEduSystem\Filament\Admin\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Liamtseva\PGFKEduSystem\Filament\Resources\WorkerResource\Pages;
use Liamtseva\PGFKEduSystem\Filament\Resources\WorkerResource\RelationManagers;
use Liamtseva\PGFKEduSystem\Models\Worker;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;

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
            'index' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Pages\ListWorkers::route('/'),
            'create' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Pages\CreateWorker::route('/create'),
            'edit' => \Liamtseva\PGFKEduSystem\Filament\Admin\Resources\WorkerResource\Pages\EditWorker::route('/{record}/edit'),
        ];
    }
}
