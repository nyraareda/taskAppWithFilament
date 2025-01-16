<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                Section::make('Task Details')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->required()
                                ->rules(['min:3', 'string', 'regex:/^[^0-9]*$/']),
                            Textarea::make('description')
                                ->label('Description')
                                ->rules(['min:3', 'string', 'regex:/^[^0-9]*$/'])
                                ->required(),
                        ]),
                    ]),
                Section::make('Task Information')
                    ->icon('heroicon-o-pencil')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            DateTimePicker::make('deadline')
                                ->label('Deadline')
                                ->required()
                                ->rules(['after:tomorrow'])
                                ->hint('Select a deadline that is after today')
                                ->prefixIcon('heroicon-o-calendar') // Add calendar icon to the field
                                ->default(now()),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'completed' => 'Completed',
                                ])
                                ->default('pending'),
                        ]),
                    ]),
            Section::make('Category')
                ->icon('heroicon-o-rectangle-stack')
                 ->schema([
                    Grid::make(1) // One column for category
                    ->schema([
                     Select::make('category_id')
                         ->hint('You can search and select the category')
                        ->relationship('category', 'name')
                        ->required()
                        ->label('Category')
                        ->searchable(),

                    ]),
                 ]),
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
                Tables\Actions\DeleteAction::make(),

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
