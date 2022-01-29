<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {

        return [
           'id'=>'required|integer',
           'service_id'=>'required|integer',
           'name'=>'required|string',
           'max_passenger'=>'required|integer',
           'picture'=>'nullable|sometimes|image|mimes:jpeg,png,jpg',
        ];  

    }

    public function messages(){

        return [
            'id.required'=>'A record must be selected!',
            'id.integer'=>'Invalid registration!',
            'service_id.required'=>'service is required',
            'service_id.integer'=>'invalid format',
            'name.required'=>'name is required',
            'name.string'=>'invalid format',
            'max_passenger.required'=>'max passenger is required',
            'max_passenger.integer'=>'invalid format',
        ];

    }
}
