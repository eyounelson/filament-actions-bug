<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'subject_id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('date')
                        ->getStateUsing(
                            fn ($record) => $record->created_at->isToday()
                                ? $record->created_at->diffForHumans()
                                : $record->created_at->toDayDatetimeString()
                        )
                        ->icon('heroicon-o-calendar'),

                    Tables\Columns\TextColumn::make('description')
                        ->formatStateUsing(fn ($state) => new HtmlString(
                            "<p class='text-base font-thin text-gray-900 dark:text-white'>$state</p>"
                        )),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('causer')
                            ->formatStateUsing(fn ($state) => 'Caused by '.($state->name ?? $state->fullname ?? 'System'))
                            ->icon('heroicon-o-cursor-arrow-rays'),
                    ])
                        ->grow(false),
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                //
                //
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('id', 'desc');
    }
}
