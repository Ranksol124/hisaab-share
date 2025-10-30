<?php

namespace App\Filament\Resources\CategoryResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
			'categorytID' => 'nullable',
			'color' => 'required',
            'user_id'=>'required',
			'icon' => 'required',
			'iconFontFamily' => 'nullable',
			'iconFontPackage' => 'nullable',
            'bgColor' => 'required',
			'name' => 'nullable',
			'title' => 'required',
            'position'=>'required',
            'isDefault' => 'required',
		];
    }
}
