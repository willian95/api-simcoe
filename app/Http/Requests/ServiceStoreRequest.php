<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            //Service
           'name'=>'required|string',
           'is_shared_and_private'=>'required|boolean',
           'has_groups'=>'required|boolean',
           'icon'=>'required|string',
           'description'=>'required|string',
            //ServiceInfoRate
           'info_rates.max_pets'=>'required|integer',
           'info_rates.max_bags'=>'required|integer',
           'info_rates.max_passager'=>'required|integer',
           'info_rates.max_carry_on_bag'=>'required|integer',
           'info_rates.max_stops'=>'required|integer',
            //ServiceType
           'service_types'=>'required|array',
            //Price
            'prices'=>'required|array',
           
        ];  

    }

    public function messages(){

        return [
            //Service
            'name.required'=>'name is required',
            'name.string'=>'invalid format',
            'is_shared_and_private.required'=>'is shared and private is required',
            'is_shared_and_private.boolean'=>'invalid format',
            //ServiceInfoRate
            'info_rates.max_pets.required'=>'max pets is required',
            'info_rates.max_pets.integer'=>'invalid format',
            'info_rates.max_bags.required'=>'max bags is required',
            'info_rates.max_bags.integer'=>'invalid format',
            'info_rates.max_passager.required'=>'max passager is required',
            'info_rates.max_passager.integer'=>'invalid format',
            'info_rates.max_carry_on_bag.required'=>'max carry on bag is required',
            'info_rates.max_carry_on_bag.integer'=>'invalid format',
            'info_rates.max_stops.required'=>'max stops is required',
            'info_rates.max_stops.integer'=>'invalid format',
             //ServiceType
            'service_types.required'=>'service types is required',
            'service_types.array'=>'invalid format',
            //Price
            'prices.required'=>'prices is required',
            'prices.array'=>'invalid format',
        ];

    }

}
