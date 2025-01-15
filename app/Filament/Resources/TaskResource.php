<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('description')->required(),
                DateTimePicker::make('deadline')->required(),
                Select::make('status')->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                ])->default('pending')->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Category')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Task Title'),
                TextColumn::make('description')->label('Description'),
                TextColumn::make('deadline')->label('Deadline')->date()->sortable(),
                TextColumn::make('status')->label('Status'),
                TextColumn::make('category.name')->label('Category'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                    ])
                    ->attribute('status')
                    ->label('Status'),
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->label('Category')
                //selectFilter::make('category')
                //                    ->options(Category::getCategoryOptions())  //method i made in model
                //                    ->attribute('category_id')
                //                    ->label('Category')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('deadline');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
