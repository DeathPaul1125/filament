<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipoResource\Pages;
use App\Filament\Resources\EquipoResource\RelationManagers;
use App\Models\Equipo;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;

class EquipoResource extends Resource
{
    protected static ?string $model = Equipo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                TextInput::make('ip'),
                TextInput::make('modelo'),
                TextInput::make('marca'),
                TextInput::make('serie'),
                TextInput::make('usuario'),
                TextInput::make('dominio'),
                TextInput::make('so'),
                TextInput::make('soversion'),
                TextInput::make('location'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip')->searchable(),
                TextColumn::make('modelo')->searchable(),
                TextColumn::make('marca')->searchable(),
                TextColumn::make('serie')->searchable(),
                TextColumn::make('usuario')->searchable(),
                TextColumn::make('dominio'),
                TextColumn::make('so')->searchable(),
                TextColumn::make('soversion'),
            ])
            ->filters([

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

    public function myCustomAction()
    {
        // Lógica que se ejecutará al hacer clic en el botón
        Filament::notify('success', '¡Acción ejecutada con éxito!');
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
            'index' => Pages\ListEquipos::route('/'),
            'create' => Pages\CreateEquipo::route('/create'),
            'edit' => Pages\EditEquipo::route('/{record}/edit'),
        ];
    }
}
