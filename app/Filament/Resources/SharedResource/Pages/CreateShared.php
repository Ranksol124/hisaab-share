<?php

namespace App\Filament\Resources\SharedResource\Pages;

use App\Filament\Resources\SharedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateShared extends CreateRecord
{
    protected static string $resource = SharedResource::class;
}
