<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
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
           'service_id'=>'required|integer',
           'name'=>'required|string',
            //Price
            'prices'=>'required|array',
        ];  

    }

    public function messages(){

        return [
            //Group
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
