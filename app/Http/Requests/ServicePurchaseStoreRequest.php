<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicePurchaseStoreRequest extends FormRequest
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
            'service_type_id'        =>'required|integer',
            'to_airport_group_id'    =>'required|integer',
            'to_return_group_id'     =>'required|integer',
            'airport_id'             =>'required|integer',
            'payment_type_id'        =>'required|integer',
            'pickup_base_borden'     =>'required|boolean',
            'return_base_borden'     =>'required|boolean',
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|string|email|max:255',
            'phone_number'           => 'required|string|email|max:255',
            'destination'            => 'required|string|email|max:255',
            'pickup_postal_code'     => 'required|string|email|max:255',
            'pickup_street'          => 'required|string|email|max:255',
            'pickup_unit'            => 'required|string|email|max:255',
            'dropoff_postal_code'    => 'required|string|email|max:255',
            'dropoff_street'         => 'required|string|email|max:255',
            'dropoff_unit'           => 'required|string|email|max:255',
            'purchase_status'        => 'required|string|email|max:255',
            'total'                  => 'required',
            'total_hash'             => 'required',

        ];
    }
}

