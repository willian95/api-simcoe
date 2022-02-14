<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EncryptTotalRequest;
use App\Http\Requests\ServicePurchaseStoreRequest;
use App\Models\Admin\ServicePurchase;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class CheckoutController extends Controller
{
    public function EncryptTotal(EncryptTotalRequest $request){

        try{

            return response()->json(["success" => true,"message" => "Data obtained successfully", "total"=>encryptValue($request->total)]);

        }catch(\Exception $e){

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to get the data"], 200);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(ServicePurchaseStoreRequest $request)
    {
        try{

            DB::beginTransaction();

            if(floatval($request->total)!=floatval(decryptStringValue($request->total_hash)))

                return response()->json(["success" => false, "message" => "Total is required"], 200);

            $ServicePurchase = ServicePurchase::create([
                'service_type_id'          => $request->get('service_type_id'),
                'to_airport_group_id'      => $request->get('to_airport_group_id'),
                'to_return_group_id'       => $request->get('to_return_group_id'),
                'airport_id'               => $request->get('airport_id'),               
                'payment_type_id'          => $request->get('payment_type_id'),
                'init_date_park'           => $request->get('init_date_park'),               
                'end_date_park'            => $request->get('end_date_park'),
                'to_airport_passengers'    => $request->get('to_airport_passengers'),               
                'to_airport_bags'          => $request->get('to_airport_bags'),
                'to_airport_pets'          => $request->get('to_airport_pets'),               
                'to_airport_flight_number' => $request->get('to_airport_flight_number'),
                'to_airport_is_private'    => $request->get('to_airport_is_private'),               
                'to_airport_is_shared'     => $request->get('to_airport_is_shared'),
                'departure_time'           => $request->get('departure_time'),               
                'departure_date'           => $request->get('departure_date'),
                'to_airport_stops'         => $request->get('to_airport_stops'),               
                'to_return_passengers'     => $request->get('to_return_passengers'),
                'to_return_bags'           => $request->get('to_return_bags'),               
                'to_return_pets'           => $request->get('to_return_pets'),
                'to_return_flight_number'  => $request->get('to_return_flight_number'),               
                'to_return_is_private'     => $request->get('to_return_is_private'),
                'to_return_is_shared'      => $request->get('to_return_is_shared'),               
                'to_return_time'           => $request->get('to_return_time'),
                'to_return_date'           => $request->get('to_return_date'),               
                'to_return_stops'          => $request->get('to_return_stops'),
                'pickup_base_borden'       => $request->get('pickup_base_borden'),
                'return_base_borden'       => $request->get('return_base_borden'),
                'name'                     => $request->get('name'),
                'email'                    => $request->get('email'),
                'phone_number'             => $request->get('phone_number'),
                'destination'              => $request->get('destination'),
                'pickup_postal_code'       => $request->get('pickup_postal_code'),
                'pickup_street'            => $request->get('pickup_street'),
                'pickup_unit'              => $request->get('pickup_unit'),
                'dropoff_postal_code'      => $request->get('dropoff_postal_code'),
                'dropoff_street'           => $request->get('dropoff_street'),
                'dropoff_unit'             => $request->get('dropoff_unit'),
                'purchase_status'          => $request->get('purchase_status'),
                'total'                    => $request->get('total'),
            ]);

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "ServicePurchase"=>$ServicePurchase], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to register"], 200);

        }
    }
}
