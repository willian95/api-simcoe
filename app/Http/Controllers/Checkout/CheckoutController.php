<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EncryptTotalRequest;
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
}
