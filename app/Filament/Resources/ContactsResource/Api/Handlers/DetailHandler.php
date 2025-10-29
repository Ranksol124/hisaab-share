<?php

namespace App\Filament\Resources\ContactsResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ContactsResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ContactsResource\Api\Transformers\ContactsTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ContactsResource::class;
    public static bool $public = true;

    /**
     * Show Contacts
     *
     * @param Request $request
     * @return ContactsTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ContactsTransformer($query);
    }
}
