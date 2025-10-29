<?php

namespace App\Filament\Resources\SharedResource\Pages;

use App\Filament\Resources\SharedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShareds extends ListRecords
{
    protected static string $resource = SharedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
