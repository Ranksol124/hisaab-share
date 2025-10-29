<?php
namespace App\Filament\Resources\ContactsResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Contacts;

/**
 * @property Contacts $resource
 */
class ContactsTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
