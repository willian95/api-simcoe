<?php

namespace App\Http\Controllers\PaymentType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentTypeStoreRequest;
use App\Http\Requests\PaymentTypeUpdateRequest;
use App\Http\Requests\PaymentTypeDestroyRequest;
use App\Http\Requests\PaymentTypeRestoreRequest;
use App\Models\Admin\PaymentType;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class PaymentTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentTypeStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $PaymentType = PaymentType::create([
                'description' => $request->get('description'),
                'icon' => $request->get('icon'),
            ]);

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "PaymentType"=>$PaymentType], 201);

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

            $PaymentType = PaymentType::all();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "PaymentType"=>$PaymentType]);

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
    public function update(PaymentTypeUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $PaymentType=PaymentType::where("id",$id)->first();

            if($PaymentType==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $repeated=PaymentType::where("id","<>",$PaymentType->id)->where("description",$request->description)->first();    
            
            if($repeated!=null)

                return response()->json(["success" => false, "message" => "There is already a record created with that description!"], 200);


            $PaymentType->fill([
                               'description' => $request->get('description'),
                               'icon' => $request->get('icon'),
            ])->save();

            DB::commit();

            return response()->json(["success" => true,"message" => "Successful update", "PaymentType"=>$PaymentType], 201);

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
    
            $PaymentType=PaymentType::where("id",$id)->first();

            if($PaymentType==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
 
            $PaymentType->delete();

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
    public function restore(PaymentTypeRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $PaymentType=PaymentType::withTrashed()->find($request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!", "PaymentType"=>$PaymentType], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
