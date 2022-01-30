<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
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
            //Group
           'id'=>'required|integer',
           'name'=>'required|string',
           'service_id'=>'required|integer',
            //Price
            'prices'=>'required|array',
        ];  

    }

    public function messages(){

        return [
            //Group
            'id.required'=>'A record must be selected!',
            'id.integer'=>'Invalid registration!',
            'service_id.required'=>'service is required',
            'service_id.integer'=>'invalid format',
            'name.required'=>'name is required',
            'name.string'=>'invalid format',
            //Price
            'prices.required'=>'prices is required',
            'prices.array'=>'invalid format',
        ];

    }
}
