<?php

namespace App\Http\Controllers\ServiceType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ServiceType;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class ServiceTypeController extends Controller
{
    /**
     * Get Service Type .
     *
     * @return \Illuminate\Http\Response
     */
    public function ServiceTypeSearch($service_id)
    {
        try{

            $serviceTypes = ServiceType::where('service_id', $service_id)->get();

            if(count($serviceTypes)==0)

                return response()->json(["success" => false, "message" => "record not found"], 200);

            return response()->json(["success" => true,"message" => "Data obtained successfully", "serviceTypes"=>$serviceTypes]);

        }catch(\Exception $e){

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to get the data"], 200);

        }

    }

    /*
     * Get Service Type Info.
     *
     * @return \Illuminate\Http\Response
     */
    public function ServiceTypeInfoSearch($service_id)
    {
        try{

            $serviceTypes = ServiceType::with(['Service'])->where('service_id', $service_id)->get();

            if(count($serviceTypes)==0)

                return response()->json(["success" => false, "message" => "record not found"], 200);

                $info=array();
    
                foreach($serviceTypes as &$serviceType){
    
                    $info=[
                        //ServiceType
                        'id'                   =>$serviceType->id,
                        'service_type_name'    =>$serviceType->name,
                        'is_only_private'      =>$serviceType->is_only_private==0?'false':'true',
                        'discount_percentage'  =>$serviceType->discount_percentage,
                        //Service
                        'service_id'           =>$serviceType->id,
                        'service_name'         =>$serviceType->Service->name,
                        'is_shared_and_private'=>$serviceType->Service->is_shared_and_private==0?'false':'true',
                        'has_groups'           =>$serviceType->Service->has_groups==0?'false':'true',
                        'icon'                 =>$serviceType->Service->icon,
                        'depot_address'        =>$serviceType->Service->depot_address,
                        'description'          =>$serviceType->Service->description,
                        'advice'               =>$serviceType->Service->advice,
                        'second_advice'        =>$serviceType->Service->second_advice,
                        'apply_sold_out'       =>$serviceType->Service->apply_sold_out==0?'false':'true',
                        'is_sold_out'          =>$serviceType->Service->is_sold_out==0?'false':'true',
                        'purchase_advice'      =>$serviceType->Service->purchase_advice,
                        //ServiceInfoRate
                        'max_pets'             =>$serviceType->Service->ServiceInfoRate->max_pets,
                        'max_bags'             =>$serviceType->Service->ServiceInfoRate->max_bags,
                        'max_passager'         =>$serviceType->Service->ServiceInfoRate->max_passager,
                        'max_carry_on_bag'     =>$serviceType->Service->ServiceInfoRate->max_carry_on_bag,
                        'max_stops'            =>$serviceType->Service->ServiceInfoRate->max_stops,
                        ];
    
                }
                  

            return response()->json(["success" => true,"message" => "Data obtained successfully", "serviceTypes"=>$info]);

        }catch(\Exception $e){

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to get the data"], 200);

        }
    }    
}
