<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Requests\VehicleDestroyRequest;
use App\Http\Requests\VehicleRestoreRequest;
use App\Models\Admin\Vehicle;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class VehicleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $vehicle = Vehicle::create([
                'service_id' => $request->get('service_id'),
                'name' => $request->get('name'),
                'max_passenger' => $request->get('max_passenger'),
                'is_private' => $request->get('is_private'),
                'is_shared' => $request->get('is_shared'),
            ]);

            if($request->hasFile('picture'))
            {

                $vehicle->picture = picture($request,$vehicle->id);

                $vehicle->save();

            }


            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "vehicle"=>$vehicle], 201);

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

            $vehicle = Vehicle::with(['Sevice'])->get();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "vehicle"=>$vehicle]);

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
    public function update(VehicleUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $vehicle=Vehicle::where("id",$id)->first();

            if($vehicle==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $vehicle->fill([                
                'service_id' => $request->get('service_id'),
                'name' => $request->get('name'),
                'picture' =>picture($request,$id),
                'max_passenger' => $request->get('max_passenger'),
                'is_private' => $request->get('is_private'),
                'is_shared' => $request->get('is_shared'),
                ])->save();

            DB::commit();

            return response()->json(["success" => true,"message" => "Successful update", "vehicle"=>$vehicle], 201);

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
    
            $vehicle=Vehicle::where("id",$id)->first();

            if($vehicle==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
 
            $vehicle->delete();

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
    public function restore(VehicleRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $vehicle=Vehicle::withTrashed()->find($request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!", "vehicle"=>$vehicle], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
