<?php

namespace App\Http\Controllers\Town;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TownStoreRequest;
use App\Http\Requests\TownUpdateRequest;
use App\Http\Requests\TownDestroyRequest;
use App\Http\Requests\TownRestoreRequest;
use App\Models\Admin\Town;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class TownController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TownStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $town = Town::create([
                'group_id' => $request->get('group_id'),
                'name' => $request->get('name'),
            ]);

            DB::commit();

            return response()->json(["success" => true,"message" => "Registered successfully", "town"=>$town], 201);

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

            $town = Town::with(['Group'])->paginate(15);
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "town"=>$town]);

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
    public function update(TownUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $town=Town::where("id",$id)->first();

            if($town==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
        
            $town->fill([
                'group_id' => $request->group_id,
                'name'=>$request->name,
            ])->save();

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
    
            $town=Town::where("id",$id)->first();

            if($town==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
 
            $town->delete();

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
    public function restore(TownRestoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $town=Town::withTrashed()->find($request->id)->restore();

            DB::commit();

            return response()->json(["success" => true,"message" => "Registry successfully restored!"], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error trying to restore the registry"], 200);

        }
    }
}
