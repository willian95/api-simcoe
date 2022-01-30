<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Requests\GroupDestroyRequest;
use App\Http\Requests\GroupRestoreRequest;
use App\Models\Admin\Group;
use App\Models\Admin\Price;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class GroupController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        try{

            DB::beginTransaction();
    
            $group = Group::create([
                'service_id' => $request->get('service_id'),
                'name' => $request->get('name'),
            ]);

            foreach ($request->prices as $price) {

                $price=Price::create([
                    'group_id'=>$group->id,
                    'airport_id'=>$price['airport_id'],
                    'shared_price'=>$price['shared_price'],	
                    'private_price'=>$price['private_price'],
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

            $group = Group::with(['Service','Price'])->get();
              
            return response()->json(["success" => true,"message" => "Data obtained successfully", "group"=>$group]);

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
    public function update(GroupUpdateRequest $request, $id)
    {
        try{

            DB::beginTransaction();
    
            $group=Group::where("id",$id)->first();

            if($group==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);
            
            $group->fill([                
                            'service_id' => $request->get('service_id'),
                            'name' => $request->get('name'),
                        ])->save();

            foreach ($request->prices as $price) {

                $price=Price::where("id",$price['id'])->first();
            
                $price->fill([
                                'airport_id'=>$price['airport_id'],
                                'shared_price'=>$price['shared_price'],	
                                'private_price'=>$price['private_price'],
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
    
            $group=Group::where("id",$id)->first();

            if($group==null)

                return response()->json(["success" => false, "message" => "Record not found!"], 200);

            $price=Price::where('group_id',$id)->delete();  
 
            $group->delete();

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
    public function restore(GroupRestoreRequest $request)
    {
        try{

            DB::beginTransaction();

            $group=group::withTrashed()->find($request->id)->restore();

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
