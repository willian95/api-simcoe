<?php

namespace App\Http\Controllers\Airport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AirportStoreRequest;
use App\Http\Requests\AirportUpdateRequest;
use App\Http\Requests\AirportDestroyRequest;
use App\Http\Requests\AirportRestoreRequest;
use App\Models\Admin\Airport;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class AirportController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirportStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $airport = Airport::create([
                'name' => $request->get('name'),
            ]);

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "airport"=>$airport], 201);

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

            $airport = Airport::all();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "airport"=>$airport]);

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
    public function update(AirportUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $airport=Airport::where("id",$id)->first();

            if($airport==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $repeated=Airport::where("id","<>",$airport->id)->where("name",$request->name)->first();    
            
            if($repeated!=null)

                return response()->json(["success" => false, "message" => "There is already a record created with that name!"], 200);


            $airport->fill(['name'=>$request->name])->save();

            DB::commit();

            return response()->json(["success" => true,"message" => "Successful update", "airport"=>$airport], 201);

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
    
            $airport=Airport::where("id",$id)->first();

            if($airport==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
 
            $airport->delete();

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
    public function restore(AirportRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $airport=airport::withTrashed()->find($request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!", "airport"=>$airport], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
