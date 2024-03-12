<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRatingRequest extends FormRequest
{
    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "restaurant_uuid" =>"required|string|min:10|max:40|exists:restaurants,uuid",
            "rate" => "required|integer|min:0|max:5",
            "comment" => "nullable|string|max:255",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField($validator->errors()));
    }
}
