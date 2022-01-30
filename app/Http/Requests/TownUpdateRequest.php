<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TownUpdateRequest extends FormRequest
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
            'group_id'=>'required|integer',
            'name'=>'required|string',
        ];
    }

    public function messages(){

        return [
            'id.required'=>'A record must be selected!',
            'id.integer'=>'Invalid registration!',
            'group_id.required'=>'group is required',
            'group_id.integer'=>'invalid format',
            'name.required'=>'name is required',
            'name.string'=>'invalid format',
        ];

    }
}
