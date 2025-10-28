<?php

namespace App\Http\ApiRequest;

use Saeed\CustomApi\Request\apiFormRequest;

class UrlStoreApiRequest extends apiFormRequest
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
            'url' => ['required', 'url', 'max:2000'],
            'ttl_days' => ['nullable','integer','min:1','max:365']
        ];
    }
}
