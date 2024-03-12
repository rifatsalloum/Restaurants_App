<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            "name" => "required|string|min:2|max:255",
            "email" => "required|email|ends_with:gmail.com,yahoo.com,hotmail.com|unique:users,email|min:11|max:255",
            "password" => "required|string|min:3|max:255"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField($validator->errors()));
    }
}
