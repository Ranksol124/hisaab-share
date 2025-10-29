<?php
namespace App\Filament\Resources\ContactsResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ContactsResource;
use Illuminate\Routing\Router;


class ContactsApiService extends ApiService
{
    protected static string | null $resource = ContactsResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
