<?php

namespace App\Filament\Resources\ContactsResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'idcontacts' => 'required',
			'name' => 'required',
			'amount' => 'required',
			'mobileNo' => 'required',
			'email' => 'required',
			'address' => 'required',
			'isSharedView' => 'required',
			'sharedUserId' => 'required',
			'sharedCategoryId' => 'required',
			'originalContactId' => 'required',
			'category' => 'required',
			'allowReceiverToAddTransactions' => 'required',
			'sharedBy_name' => 'required',
			'sharedBy_email' => 'required',
			'sharedBy_mobileNo' => 'required',
			'sharedBy_imageUrl' => 'required'
		];
    }
}
