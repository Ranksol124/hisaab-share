<?php

namespace App\Filament\Resources\ContactsResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ContactsResource;
use App\Filament\Resources\ContactsResource\Api\Requests\CreateContactsRequest;

class CreateHandler extends Handlers
{
    public static string | null $uri = '/';
    public static string | null $resource = ContactsResource::class;
    public static bool $public = true;
    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Create Contacts
     *
     * @param CreateContactsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateContactsRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}
