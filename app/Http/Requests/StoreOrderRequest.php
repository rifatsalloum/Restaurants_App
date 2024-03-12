<?php

namespace App\Http\Requests;

use App\Http\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
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
            "data" => "required|array",
            "data.*" => "required|array",
            "data.*.*" => "required|integer|min:1|max:100",
            "type" => "required|string|in:delivery,pickup",
        ];
    }

    public function checkInMenu($restaurant_uuids,$menu_items) : bool
    {
        $c = 1;

        $restaurant_uuids->each(function ($uuid) use (&$c,$menu_items) {
            foreach ($this->data[$uuid] as $item_uuid => $number)
              $c &= isset($menu_items[$uuid][$item_uuid]);
        });

        return $c;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->requiredField($validator->errors()));
    }
}
