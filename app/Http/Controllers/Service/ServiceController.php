<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Requests\ServiceDestroyRequest;
use App\Http\Requests\ServiceRestoreRequest;
use App\Models\Admin\Service;
use App\Models\Admin\ServiceInfoRate;
use App\Models\Admin\ServiceType;
use App\Models\Admin\Price;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class ServiceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        try{

            DB::beginTransaction();

            $service = Service::create([
                'name'=> $request->get('name'),
                'is_shared_and_private'=> $request->get('is_shared_and_private'),
                'has_groups'=> $request->get('has_groups'),
                'icon'=> $request->get('icon'),
                'depot_address'=> $request->get('depot_address'),
                'description'=> $request->get('description'),
                'advice'=> $request->get('advice'),
                'second_advice'=> $request->get('second_advice'),
                'apply_sold_out'=> $request->get('apply_sold_out'),
                'is_sold_out'=> $request->get('is_sold_out'),
                'purchase_advice'=> $request->get('purchase_advice'),
            ]);

            $serviceInfoRate=ServiceInfoRate::create([
                'service_id'=> $service->id,
                'max_pets'=> $request->info_rates['max_pets'],
                'max_bags'=> $request->info_rates['max_bags'],
                'max_passager'=> $request->info_rates['max_passenger'],
                'max_carry_on_bag'=> $request->info_rates['max_carry_on_bag'],
                'max_stops'=>$request->info_rates['max_stops'],
            ]);

            foreach ($request->service_types as $service_type) {

                $serviceType=ServiceType::create([
                    'service_id'=> $service->id,
                    'name'=> $service_type['name'],
                    'is_only_private'=> $service_type['is_only_private'],
                    'discount_percentage'=> $service_type['discount_percentage'],
                ]);

            }

            foreach ($request->prices as $price) {

                $price=Price::create([

                    'airport_id'=>$price['airport_id'],
                    'service_id'=> $service->id,
                    'group_id'=>$price['group_id'] ?? 1, //Eliminar luego
                    'shared_price'=>$price['shared_price'],	
                    'private_price'=>$price['private_price'],
                    'unique_price'=>$price['unique_price'],
                    'base_borden_price'=>$price['base_borden_price'],
                    'extra_passenger_fee'=>$price['extra_passenger_fee'],
                    'extra_family_price'=>$price['extra_family_price'],	
                    'parking_day_price'=>$price['parking_day_price'],
                    'price_per_stop'=>$price['price_per_stop'], 
                    
                ]);

            }

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully"], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to register"], 200);

        }
    }

    /**
     * List of saved records.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        try{

            $service = Service::with(['ServiceInfoRate','ServiceTypes','Prices.Group'])->get();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "service"=>$service]);

        }catch(\Exception $e){

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to get the data"], 200);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $service=Service::where("id",$id)->first();

            if($service==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $service->fill([
                  'name'=> $request->get('name'),
                  'is_shared_and_private'=> $request->get('is_shared_and_private'),
                  'has_groups'=> $request->get('has_groups'),
                  'icon'=> $request->get('icon'),
                  'depot_address'=> $request->get('depot_address'),
                  'description'=> $request->get('description'),
                  'advice'=> $request->get('advice'),
                  'second_advice'=> $request->get('second_advice'),
                  'apply_sold_out'=> $request->get('apply_sold_out'),
                  'is_sold_out'=> $request->get('is_sold_out'),
                  'purchase_advice'=> $request->get('purchase_advice'),
            ])->save();

            $serviceInfoRate=ServiceInfoRate::where("id",$request->info_rates['id'])->first();

            if($serviceInfoRate==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);

            $serviceInfoRate->fill([
                'max_pets'=> $request->info_rates['max_pets'],
                'max_bags'=> $request->info_rates['max_bags'],
                'max_passager'=> $request->info_rates['max_passenger'],
                'max_carry_on_bag'=> $request->info_rates['max_carry_on_bag'],
                'max_stops'=>$request->info_rates['max_stops'],
            ])->save();

            foreach ($request->service_types as $service_type) {

                $serviceType=ServiceType::where("id",$service_type['id'])->first();

                $serviceType->fill([
                    'name'=> $service_type['name'],
                    'is_only_private'=> $service_type['is_only_private'],
                    'discount_percentage'=> $service_type['discount_percentage'],
                ])->save();

            }

            foreach ($request->prices as $price) {

                $price=Price::where("id",$price['id'])->first();

                $price->fill([

                    'airport_id'=>$price['airport_id'],
                    'service_id'=> $service->id,
                    'group_id'=>$price['group_id'],
                    'shared_price'=>$price['shared_price'],	
                    'private_price'=>$price['private_price'],
                    'unique_price'=>$price['unique_price'],
                    'base_borden_price'=>$price['base_borden_price'],
                    'extra_passenger_fee'=>$price['extra_passenger_fee'],
                    'extra_family_price'=>$price['extra_family_price'],	
                    'parking_day_price'=>$price['parking_day_price'],
                    'price_per_stop'=>$price['price_per_stop'], 
                    
                ])->save();

            }

            DB::commit();

            return response()->json(["success" => true,"message" => "Successful update"], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to update"], 200);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            DB::beginTransaction();
    
            $service=Service::where("id",$id)->first();

            if($service==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);

            $serviceInfoRate=ServiceInfoRate::where('service_id',$id)->delete();

            $serviceType=ServiceType::where('service_id',$id)->delete();   
            
            $price=Price::where('service_id',$id)->delete();   

            $service->delete();

            DB::commit();

            return response()->json(["success" => true,"message" => "Record deleted successfully!"], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to delete the record"], 200);

        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(ServiceRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $service=Service::withTrashed()->find($request->id)->restore();

            $serviceInfoRate=ServiceInfoRate::withTrashed()->where('service_id',$request->id)->restore();

            $serviceType=ServiceType::withTrashed()->where('service_id',$request->id)->restore();

            $price=Price::withTrashed()->where('service_id',$request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!"], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
