<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('Assign')
                ->color('secondary')
                ->form([
                    Forms\Components\Select::make('assign_to')
                        ->options(User::pluck('name', 'id'))
                        ->required(),
                ])
                ->action(fn (array $data, Product $record) => $this->assignProduct($data, $record)),
        ];
    }

    public static function assignProductAction()
    {
        return Infolists\Components\Actions\Action::make('Assign')
            ->form([
                Forms\Components\Select::make('assign_to')
                    ->options(User::pluck('name', 'id'))
                    ->required(),
            ])
            ->action(fn (array $data, Product $record) => $this->assignProduct($data, $record));
    }

    private function assignProduct(array $data, Product $record): void
    {
        $message = "You have been assigned to manage $record->name!";
        $admin = Filament::auth()->user();

        \activity()
            ->performedOn($record)
            ->causedBy($admin)
            ->log("assigned product #$record->id to User #{$data['assign_to']}");

        Notification::make()
            ->title($message)
            ->sendToDatabase($admin);
    }
}
