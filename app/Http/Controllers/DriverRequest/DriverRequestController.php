<?php

namespace App\Http\Controllers\DriverRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DriverRequestStoreRequest;
use App\Http\Requests\DriverRequestUpdateRequest;
use App\Http\Requests\DriverRequestDestroyRequest;
use App\Http\Requests\DriverRequestRestoreRequest;
use App\Models\Admin\DriverRequest;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class DriverRequestController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequestStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $DriverRequest = DriverRequest::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone_number' => $request->get('phone_number'),
                'driver_license' => $request->get('driver_license'),
                'status' => $request->get('status'),
            ]);

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "DriverRequest"=>$DriverRequest], 201);

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

            $DriverRequest = DriverRequest::all();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "DriverRequest"=>$DriverRequest]);

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
    public function update(DriverRequestUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $DriverRequest=DriverRequest::where("id",$id)->first();

            if($DriverRequest==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $DriverRequest->fill([

                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone_number' => $request->get('phone_number'),
                'driver_license' => $request->get('driver_license'),
                'status' => $request->get('status'),
                
            ])->save();

            DB::commit();

            return response()->json(["success" => true,"message" => "Successful update", "DriverRequest"=>$DriverRequest], 201);

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
    
            $DriverRequest=DriverRequest::where("id",$id)->first();

            if($DriverRequest==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
 
            $DriverRequest->delete();

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
    public function restore(DriverRequestRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $DriverRequest=DriverRequest::withTrashed()->find($request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!", "DriverRequest"=>$DriverRequest], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
